<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->integer('owned_by')->after('description');           
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->integer('owned_by')->after('add_receipt');           
        });
        Schema::table('product_service_categories', function (Blueprint $table) {
            $table->integer('owned_by')->after('color');           
        });
        Schema::table('taxes', function (Blueprint $table) {
            $table->integer('owned_by')->after('rate');           
        });
        Schema::table('product_service_units', function (Blueprint $table) {
            $table->integer('owned_by')->after('name');           
        });
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->integer('owned_by')->after('bank_address');           
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->integer('owned_by')->after('category_id');           
        });
        Schema::table('goals', function (Blueprint $table) {
            $table->integer('owned_by')->after('is_display');           
        });
        Schema::table('venders', function (Blueprint $table) {
            $table->integer('owned_by')->after('avatar');           
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('owned_by')->after('date');           
        });
        // Schema::table('product_services', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('pro_image');           
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->dropColumn('owned_by');         
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('owned_by');           
        });
        Schema::table('product_service_categories', function (Blueprint $table) {
            $table->dropColumn('owned_by');          
        });
        Schema::table('taxes', function (Blueprint $table) {
            $table->dropColumn('owned_by');         
        });
        Schema::table('product_service_units', function (Blueprint $table) {
            $table->dropColumn('owned_by');          
        });
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('owned_by');           
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn('owned_by');        
        });
        Schema::table('goals', function (Blueprint $table) {
            $table->dropColumn('owned_by');        
        });
        Schema::table('venders', function (Blueprint $table) {
            $table->dropColumn('owned_by');    
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('owned_by');           
        });
        // Schema::table('product_services', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');           
        // });
    }
};
