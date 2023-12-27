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
        // Schema::table('revenues', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('description');           
        // });
        // Schema::table('payments', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('add_receipt');           
        // });
        // Schema::table('product_service_categories', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('color');           
        // });
        // Schema::table('taxes', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('rate');           
        // });
        // Schema::table('product_service_units', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('name');           
        // });
        // Schema::table('bank_accounts', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('bank_address');           
        // });
        // Schema::table('bills', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('category_id');           
        // });
        // Schema::table('goals', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('is_display');           
        // });
        // Schema::table('venders', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('avatar');           
        // });
        // Schema::table('transactions', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('date');           
        // });
        // Schema::table('product_services', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('pro_image');           
        // });
        // Schema::table('space_types', function (Blueprint $table) {
        //     $table->integer('tax_id')->after('name')->default(0);           
        //     $table->integer('account_head')->after('tax_id')->default(0);           
        // });
<<<<<<< HEAD
        // Schema::table('product_services', function (Blueprint $table) {
        //     $table->integer('space_id')->after('unit_id');           
        // });
        // Schema::table('contracts', function (Blueprint $table) {
        //     $table->integer('service_id')->after('company_id')->default(0);           
        //     $table->integer('service_price')->after('service_id')->default(0);           
        // });
        // Schema::table('employees', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('is_active');           
        // });
        // Schema::table('payslip_types', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('name');           
        // });
        // Schema::table('allowance_options', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('name');           
        // });
        // Schema::table('loan_options', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('name');           
        // });
        // Schema::table('deduction_options', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('name');           
        // });
        // Schema::table('leaves', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('status');           
        // });
        // Schema::table('chart_of_accounts', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('description');           
        // });
        // Schema::table('chart_of_account_types', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('name');           
        // });
        // Schema::table('bank_transfers', function (Blueprint $table) {
        //     $table->integer('owned_by')->after('description');           
        // });
        // Schema::table('contracts', function (Blueprint $table) {
        //     $table->integer('contract_id')->after('client_name');           
        // });
=======
        //   Schema::table('product_services', function (Blueprint $table) {
        //     $table->integer('space_id')->after('unit_id');           
        // });
          Schema::table('contracts', function (Blueprint $table) {
            $table->integer('service_id')->after('company_id')->default(0);           
            $table->integer('service_price')->after('service_id')->default(0);           
        });

>>>>>>> fe38d5df8381522d0b78bff945675cb011d1eba2
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('revenues', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('payments', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');           
        // });
        // Schema::table('product_service_categories', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');          
        // });
        // Schema::table('taxes', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('product_service_units', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');          
        // });
        // Schema::table('bank_accounts', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');           
        // });
        // Schema::table('bills', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');        
        // });
        // Schema::table('goals', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');        
        // });
        // Schema::table('venders', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');    
        // });
        // Schema::table('transactions', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');           
        // });
        // Schema::table('product_services', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');           
        // });
        // Schema::table('space_types', function (Blueprint $table) {
        //     $table->dropColumn('tax_id');
        //     $table->dropColumn('account_head');
        // });
<<<<<<< HEAD
        // Schema::table('product_services', function (Blueprint $table) {
        //     $table->dropColumn('space_id');          
        // });
        // Schema::table('contracts', function (Blueprint $table) {
        //     $table->dropColumn('service_id');          
        //     $table->dropColumn('service_price');          
        // });
        // Schema::table('employees', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('deduction_options', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('loan_options', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('allowance_options', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('payslip_types', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('leaves', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('chart_of_accounts', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('chart_of_account_types', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('bank_transfers', function (Blueprint $table) {
        //     $table->dropColumn('owned_by');         
        // });
        // Schema::table('contracts', function (Blueprint $table) {
        //     $table->dropColumn('contract_id');         
        // });
=======
        //  Schema::table('product_services', function (Blueprint $table) {
        //     $table->dropColumn('space_id');          
        // });
         Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('service_id');          
            $table->dropColumn('service_price');          
        });
>>>>>>> fe38d5df8381522d0b78bff945675cb011d1eba2

    }
};
