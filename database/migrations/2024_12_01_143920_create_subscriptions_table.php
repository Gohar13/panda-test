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
        Schema::create('listing_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('url')->index();
            //Set as string as we have different formats of price and currencies (e.g 2 800 грн. / за 1 шт. or 6500 $)
            $table->string('last_price')->nullable();
            $table->timestamps();

            $table->unique(['email', 'url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listing_subscriptions', function (Blueprint $table) {
            $table->dropUnique(['email', 'url']);
        });

        // Now drop the table
        Schema::dropIfExists('subscriptions');
    }
};
