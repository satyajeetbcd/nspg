<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->string('key', 255)->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->string('key', 255)->primary();
            $table->string('owner', 255);
            $table->integer('expiration');
        });

        Schema::create('country', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->string('code', 2);
        });

        Schema::create('country_lang', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->integer('country_id');
            $table->string('lang', 2);
            $table->string('name', 100);
        });

        Schema::create('currency', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->integer('country_id');
            $table->unsignedInteger('currency_id')->unique()->index('idx_currency_id');
        });

        Schema::create('currency_lang', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->integer('currency_id');
            $table->string('lang', 2);
            $table->string('name', 50);
            $table->string('symbol', 10)->nullable();
        });

        Schema::create('customer_companies', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->unsignedBigInteger('customer_id')->index('customer_id');
            $table->char('company_name', 150);
            $table->string('cr_number', 50)->nullable();
            $table->string('vat_number', 50)->nullable();
            $table->integer('country_id');
            $table->integer('city_id');
            $table->string('address', 150)->nullable();
            $table->integer('currency_id');
            $table->string('language', 10)->default('en');
            $table->string('phone', 20)->nullable();
            $table->string('billing_phone', 20)->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::create('customer_contact', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->integer('customer_id');
            $table->string('mobile', 20);
            $table->string('phone', 20)->nullable();
        });

        Schema::create('customer_db', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->integer('customer_id');
            $table->integer('company_id');
            $table->string('db_name', 50);
            $table->string('db_username', 50);
            $table->string('db_password', 50);
            $table->string('db_key', 200);
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('email', 255)->unique('users_email_unique');
            $table->string('avatar', 100)->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamps();
            $table->string('timezone', 50)->default('UTC');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->string('uuid', 255)->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->integer('code')->unique();
            $table->integer('customer_id');
            $table->integer('company_id')->nullable();
            $table->unsignedInteger('subscription_id')->nullable()->index('invoices_subscription_id_foreign');
            $table->unsignedBigInteger('plan_id')->nullable()->index('invoices_plan_id_foreign');
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->decimal('amount', 10)->nullable();
            $table->unsignedInteger('currency_id')->nullable()->index();
            $table->enum('status', ['pending', 'paid', 'cancelled', 'refunded'])->default('pending')->index();
            $table->timestamp('due_date')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->string('id', 255)->primary();
            $table->string('name', 255);
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->string('queue', 255)->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->string('code', 2)->nullable();
            $table->string('full_name', 50)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->bigInteger('creator_id');
            $table->bigInteger('user_id');
            $table->text('type');
            $table->text('data');
            $table->tinyInteger('is_read');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->string('order_id', 255)->index();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->unsignedBigInteger('plan_id')->index();
            $table->unsignedBigInteger('previous_plan_id')->nullable()->index('orders_previous_plan_id_foreign');
            $table->decimal('price', 10);
            $table->unsignedInteger('currency_id')->nullable()->index('orders_currency_id_foreign');
            $table->enum('order_type', ['new_subscription', 'upgrade', 'downgrade', 'renewal'])->default('new_subscription')->index();
            $table->string('txn_id', 255)->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'cancelled', 'failed', 'refunded'])->default('pending')->index();
            $table->string('payment_type', 255)->nullable();
            $table->boolean('paid')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('subscription_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->timestamps();

            $table->index(['customer_id', 'payment_status']);
            $table->unique(['order_id']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->string('email', 255)->primary();
            $table->string('token', 255);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('payment_method_lang', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->integer('payment_method_id');
            $table->string('name', 70);
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->integer('system_name');
            $table->integer('country_id');
        });

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->string('tokenable_type', 255);
            $table->unsignedBigInteger('tokenable_id');
            $table->text('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();

            $table->index(['tokenable_type', 'tokenable_id']);
        });

        Schema::create('plan_features', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->unsignedBigInteger('plan_id')->index('plan_id');
            $table->integer('max_user');
            $table->boolean('module_account')->nullable();
            $table->boolean('module_crm')->nullable();
            $table->boolean('module_pos')->nullable();
            $table->boolean('module_hrm')->nullable();
            $table->boolean('module_project')->nullable();
            $table->boolean('module_manfucture')->nullable();
            $table->json('more_featrues')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });

        Schema::create('plan_lang', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->integer('plan_id');
            $table->string('lang', 2);
            $table->string('name', 50);
            $table->string('description', 100)->nullable();
        });

        Schema::create('plan_prices', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->integer('plan_id');
            $table->integer('country_id');
            $table->decimal('price', 30);
            $table->integer('currency_id');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->enum('duration', ['year', 'month', 'one_time', 'lifetime']);
            $table->boolean('trial')->nullable();
            $table->integer('trial_days')->nullable();
            $table->boolean('is_disable')->nullable();
            $table->boolean('is_visible')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->string('id', 255)->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->string('group', 255)->index();
            $table->string('key', 255)->index();
            $table->string('language_code', 5)->nullable()->index();
            $table->text('value')->nullable();
            $table->string('type', 255)->default('string');
            $table->timestamps();

            $table->unique(['group', 'key', 'language_code'], 'settings_group_key_lang_unique');
        });

        Schema::create('subscription', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->unsignedBigInteger('customer_id')->index('customer_id');
            $table->unsignedBigInteger('plan_id')->index('plan_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('grace_date')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });

        Schema::create('subscription_features', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->unsignedBigInteger('plan_id')->index('plan_id');
            $table->integer('subscription_id')->index('subscription_id');
            $table->integer('max_user');
            $table->boolean('module_account')->nullable();
            $table->boolean('module_crm')->nullable();
            $table->boolean('module_pos')->nullable();
            $table->boolean('module_hrm')->nullable();
            $table->boolean('module_project')->nullable();
            $table->boolean('module_manfucture')->nullable();
            $table->json('more_featrues')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('avatar', 200)->nullable();
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('customer_companies', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'customer_companies_ibfk_1')->references(['id'])->on('customers')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign(['currency_id'])->references(['currency_id'])->on('currency')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['plan_id'])->references(['id'])->on('plans')->onUpdate('no action')->onDelete('set null');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign(['currency_id'])->references(['currency_id'])->on('currency')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['customer_id'])->references(['id'])->on('customers')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['plan_id'])->references(['id'])->on('plans')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['previous_plan_id'])->references(['id'])->on('plans')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
        });

        Schema::table('plan_features', function (Blueprint $table) {
            $table->foreign(['plan_id'], 'plan_features_ibfk_1')->references(['id'])->on('plans')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('subscription', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'subscription_ibfk_1')->references(['id'])->on('customers')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['plan_id'], 'subscription_ibfk_2')->references(['id'])->on('plans')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('subscription_features', function (Blueprint $table) {
            $table->foreign(['plan_id'], 'subscription_features_ibfk_1')->references(['id'])->on('plans')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['subscription_id'], 'subscription_features_ibfk_2')->references(['id'])->on('subscription')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_features', function (Blueprint $table) {
            $table->dropForeign('subscription_features_ibfk_1');
            $table->dropForeign('subscription_features_ibfk_2');
        });

        Schema::table('subscription', function (Blueprint $table) {
            $table->dropForeign('subscription_ibfk_1');
            $table->dropForeign('subscription_ibfk_2');
        });

        Schema::table('plan_features', function (Blueprint $table) {
            $table->dropForeign('plan_features_ibfk_1');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_currency_id_foreign');
            $table->dropForeign('orders_customer_id_foreign');
            $table->dropForeign('orders_plan_id_foreign');
            $table->dropForeign('orders_previous_plan_id_foreign');
            $table->dropForeign('orders_user_id_foreign');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_currency_id_foreign');
            $table->dropForeign('invoices_plan_id_foreign');
        });

        Schema::table('customer_companies', function (Blueprint $table) {
            $table->dropForeign('customer_companies_ibfk_1');
        });

        Schema::dropIfExists('users');

        Schema::dropIfExists('subscription_features');

        Schema::dropIfExists('subscription');

        Schema::dropIfExists('settings');

        Schema::dropIfExists('sessions');

        Schema::dropIfExists('plans');

        Schema::dropIfExists('plan_prices');

        Schema::dropIfExists('plan_lang');

        Schema::dropIfExists('plan_features');

        Schema::dropIfExists('personal_access_tokens');

        Schema::dropIfExists('payment_methods');

        Schema::dropIfExists('payment_method_lang');

        Schema::dropIfExists('password_reset_tokens');

        Schema::dropIfExists('orders');

        Schema::dropIfExists('notifications');

        Schema::dropIfExists('languages');

        Schema::dropIfExists('jobs');

        Schema::dropIfExists('job_batches');

        Schema::dropIfExists('invoices');

        Schema::dropIfExists('failed_jobs');

        Schema::dropIfExists('customers');

        Schema::dropIfExists('customer_db');

        Schema::dropIfExists('customer_contact');

        Schema::dropIfExists('customer_companies');

        Schema::dropIfExists('currency_lang');

        Schema::dropIfExists('currency');

        Schema::dropIfExists('country_lang');

        Schema::dropIfExists('country');

        Schema::dropIfExists('cache_locks');

        Schema::dropIfExists('cache');
    }
};
