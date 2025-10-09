<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Services\OrderService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Accept an order offline and generate invoice
// Usage: php artisan order:accept {order_id} {--payment=cash} {--notes="..."}
Artisan::command('order:accept {order_id} {--payment=cash} {--notes=}', function ($order_id) {
    $payment = $this->option('payment') ?: 'cash';
    $notes = $this->option('notes');

    // Find the order by ID
    $order = Order::find($order_id);

    if (!$order) {
        $this->error("Order with ID {$order_id} not found.");
        return 1;
    }

    try {
        $order->acceptByStaff($payment, $notes);
        $this->info("Order {$order->order_id} accepted successfully and invoice generated.");
        $this->line('Order ID: ' . $order->order_id . ' (DB ID: ' . $order->id . ')');
        $this->line('Payment Type: ' . $payment);
        if ($notes) {
            $this->line('Notes: ' . $notes);
        }

        // Reload the order to get the updated invoice
        $order->load('invoices');
        if ($order->invoices->count() > 0) {
            $invoice = $order->invoices->first();
            $this->line('Invoice Code: ' . $invoice->code);
            $this->line('Amount: ' . ($invoice->currency ? $invoice->currency->getSymbol('en') : '$') . number_format($invoice->amount, 2));
            $this->line('Status: ' . $invoice->status);
        }
    } catch (\Throwable $e) {
        $this->error('Failed: ' . $e->getMessage());
        return 1;
    }

    return 0;
})->purpose('Accept an order offline and generate invoice');

// (Deprecated) db:clear-orders-invoices removed in favor of unified db:clear

// Flexible DB clear command
// Usage examples:
//  - php artisan db:clear --force                          (clears invoices, orders, subscription_features, subscription)
//  - php artisan db:clear invoices,orders --force          (clears only invoices and orders)
//  - php artisan db:clear subscriptions --force            (clears subscription and subscription_features)
Artisan::command('db:clear {tables?} {--force}', function () {
    if (!$this->option('force')) {
        $this->error('Destructive action. Re-run with --force to proceed.');
        return 1;
    }

    // Map friendly names to actual tables; include dependents where needed
    $aliases = [
        'invoices' => ['invoices'],
        'orders' => ['orders'],
        'subscriptions' => ['subscription_features', 'subscription'], // features must be cleared first
        // Allow singular forms as well
        'subscription' => ['subscription_features', 'subscription'],
        'invoice' => ['invoices'],
        'order' => ['orders'],
    ];

    // Safe truncation order to satisfy FK relations when FK checks are on; we still disable them
    $safeOrder = ['invoices', 'subscription_features', 'subscription', 'orders'];

    // Parse requested tables
    $arg = $this->argument('tables');
    $requested = [];
    if ($arg) {
        foreach (explode(',', $arg) as $token) {
            $key = trim($token);
            if ($key === '') continue;
            if (isset($aliases[$key])) {
                $requested = array_merge($requested, $aliases[$key]);
            } else {
                $this->warn("Unknown table alias '{$key}', ignoring.");
            }
        }
    } else {
        // Default: clear all relevant tables
        $requested = $safeOrder;
    }

    // Deduplicate while preserving order according to $safeOrder
    $requested = array_values(array_unique($requested));
    $toTruncate = array_values(array_intersect($safeOrder, $requested));

    if (empty($toTruncate)) {
        $this->info('Nothing to do.');
        return 0;
    }

    try {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($toTruncate as $table) {
            DB::table($table)->truncate();
            $this->line("Truncated: {$table}");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->info('Done.');
        return 0;
    } catch (\Throwable $e) {
        try { DB::statement('SET FOREIGN_KEY_CHECKS=1'); } catch (\Throwable $ignored) {}
        $this->error('Failed: ' . $e->getMessage());
        return 1;
    }
})->purpose('Delete records from specified core tables (requires --force)');
