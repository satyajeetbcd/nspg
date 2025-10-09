<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the old subscription table if it exists
        // First, drop any foreign key constraints that reference it
        try {
            DB::statement("ALTER TABLE subscription_features DROP FOREIGN KEY subscription_features_ibfk_2");
        } catch (Exception $e) {
            // Constraint may not exist, continue
        }
        
        Schema::dropIfExists('subscription');
        
        // Add country column to customers table if it doesn't exist
        if (!Schema::hasColumn('customers', 'country')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('country', 100)->nullable()->after('email');
            });
        }
        
        // Ensure customers table has plan column
        if (!Schema::hasColumn('customers', 'plan')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->unsignedBigInteger('plan')->nullable()->after('country');
                $table->foreign('plan')->references('id')->on('plans')->onDelete('set null');
            });
        }
        
    
  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the plan column
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['plan']);
            $table->dropColumn('plan');
        });
        
        // Remove the country column
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('country');
        });
    }
};
