<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //

    protected  $fillable = [
        'customer_id',
        'company_id',
        'code',
        'subscription_id',
        'plan_id',
        'order_id',
        'amount',
        'currency_id',
        'status',
        'due_date',
    ];

    protected $table = 'invoices';

    protected $casts = [
        'due_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    protected $dates = [
        'due_date',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the customer that owns the invoice
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Get the company that owns the invoice
     */
    public function company()
    {
        return $this->belongsTo(CustomerCompany::class, 'company_id', 'id');
    }

    /**
     * subscription
     * The subscription associated with the invoice
     * @return void
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
    }

    /**
     * plan
     *  The plan associated with the invoice
     * @return void
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    /**
     * Get the order that generated this invoice
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Currency relation (links to currency.currency_id)
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'currency_id');
    }


    protected static function booted()
    {
        static::creating(function ($invoice) {
            $lastInvoice = self::orderBy('id', 'desc')->first();

            if ($lastInvoice) {
                $nextNumber = intval($lastInvoice->code) + 1; // increment the last code
            } else {
                $nextNumber = 1000; // start from 1000
            }

            $invoice->code = $nextNumber; // assign the new number
        });
    }
}
