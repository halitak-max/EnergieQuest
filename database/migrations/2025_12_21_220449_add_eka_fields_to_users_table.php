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
            // Current provider fields
            $table->string('current_provider')->nullable()->after('referral_code');
            $table->string('current_tariff')->nullable()->after('current_provider');
            $table->string('current_location')->nullable()->after('current_tariff');
            $table->integer('current_consumption')->nullable()->after('current_location');
            $table->integer('current_months')->nullable()->after('current_consumption');
            $table->decimal('current_working_price', 8, 2)->nullable()->after('current_months');
            $table->decimal('current_basic_price', 8, 2)->nullable()->after('current_working_price');
            $table->decimal('current_total', 10, 2)->nullable()->after('current_basic_price');
            
            // New provider fields
            $table->string('new_provider')->nullable()->after('current_total');
            $table->string('new_tariff')->nullable()->after('new_provider');
            $table->string('new_location')->nullable()->after('new_tariff');
            $table->integer('new_consumption')->nullable()->after('new_location');
            $table->integer('new_months')->nullable()->after('new_consumption');
            $table->decimal('new_working_price', 8, 2)->nullable()->after('new_months');
            $table->decimal('new_basic_price', 8, 2)->nullable()->after('new_working_price');
            $table->decimal('new_total', 10, 2)->nullable()->after('new_basic_price');
            
            // Savings fields
            $table->decimal('savings_year1_eur', 10, 2)->nullable()->after('new_total');
            $table->decimal('savings_year1_percent', 5, 2)->nullable()->after('savings_year1_eur');
            $table->decimal('savings_year2_eur', 10, 2)->nullable()->after('savings_year1_percent');
            $table->decimal('savings_year2_percent', 5, 2)->nullable()->after('savings_year2_eur');
            $table->decimal('savings_max_eur', 10, 2)->nullable()->after('savings_year2_percent');
            $table->decimal('savings_max_percent', 5, 2)->nullable()->after('savings_max_eur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'current_provider', 'current_tariff', 'current_location', 'current_consumption', 
                'current_months', 'current_working_price', 'current_basic_price', 'current_total',
                'new_provider', 'new_tariff', 'new_location', 'new_consumption',
                'new_months', 'new_working_price', 'new_basic_price', 'new_total',
                'savings_year1_eur', 'savings_year1_percent', 'savings_year2_eur', 'savings_year2_percent',
                'savings_max_eur', 'savings_max_percent'
            ]);
        });
    }
};
