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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('project_type'); // residential, commercial, industrial
            $table->string('location');
            $table->string('capacity')->nullable(); // e.g., "5kW", "10kW"
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->date('installation_date')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->text('features')->nullable(); // JSON or text field for project features
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
