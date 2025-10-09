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
        Schema::table('users', function (Blueprint $table) {
            $table->string('type', 20)->default('customer')->after('email');
            $table->unsignedBigInteger('created_by')->nullable()->after('type');
            $table->boolean('is_active')->default(true)->after('created_by');
            $table->unsignedBigInteger('plan')->nullable()->after('is_active');
            $table->date('plan_expire_date')->nullable()->after('plan');
            $table->date('trial_expire_date')->nullable()->after('plan_expire_date');
            $table->string('vat_number', 50)->nullable()->after('trial_expire_date');
            $table->text('billing_address')->nullable()->after('vat_number');
            $table->string('billing_city', 100)->nullable()->after('billing_address');
            $table->string('billing_state', 100)->nullable()->after('billing_city');
            $table->string('billing_country', 100)->nullable()->after('billing_state');
            $table->string('billing_zip', 20)->nullable()->after('billing_country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'created_by',
                'is_active',
                'plan',
                'plan_expire_date',
                'trial_expire_date',
                'vat_number',
                'billing_address',
                'billing_city',
                'billing_state',
                'billing_country',
                'billing_zip'
            ]);
        });
    }
};
