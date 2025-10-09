<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('type'); // 'verification', 'plan_assignment', 'subscription', 'invoice', etc.
            $table->string('action'); // 'assigned', 'upgraded', 'created', 'renewed', etc.
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('related_id')->nullable(); // plan_id, subscription_id, invoice_id, etc.
            $table->string('related_type')->nullable(); // 'plan', 'subscription', 'invoice', etc.
            $table->string('token')->unique(); // Secure token for link validation
            $table->timestamp('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->integer('attempt_count')->default(1);
            $table->timestamps();
            
            $table->index(['email', 'type', 'action']);
            $table->index(['customer_id', 'type']);
            $table->index('token');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_attempts');
    }
};
