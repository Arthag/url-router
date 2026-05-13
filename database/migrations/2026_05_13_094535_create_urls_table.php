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
        Schema::create('url_routes', function (Blueprint $table) {
            $table->id();
            $table->text('target_url')->nullable(false);
            $table->string('slug',20)->nullable(false)->unique();
            $table->integer('click_counter')->default(0);
            $table->timestamp('valid_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url_routes');
    }
};
