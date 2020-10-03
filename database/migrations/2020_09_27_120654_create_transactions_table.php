<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('financial_year')->nullable(); //السنة المالية
            $table->date('start_financial_year')->nullable(); // بداية السنة المالية
            $table->date('end_financial_year')->nullable(); //نهاية السنة المالية

            $table->date('start_financial_period')->nullable(); // بداية الفتره المالية
            $table->date('end_financial_period')->nullable();       // نهاية الفتره المالية

            $table->string('measurement_standard_determinants')->nullable(); //معيار القياس
            $table->string('measurement_standard')->nullable(); //معيار القياس
            $table->unsignedBigInteger('measurement_standard_price')->nullable(); // قيمة معيار القياس
            $table->unsignedBigInteger('automatic_contract_value')->nullable(); //قيمة التعاقد آليا
            $table->unsignedBigInteger('agreed_contract_value')->nullable(); //قيمة التعاقد المتفق عليها
            $table->unsignedBigInteger('down_payment')->nullable(); //الدفعة المقدمة
            $table->unsignedBigInteger('final_payment')->nullable(); //الدفعة النهائية

            $table->unsignedBigInteger('audit_fees')->nullable(); //أتعاب المراجعة
            $table->unsignedBigInteger('zakat_deposit_fees')->nullable(); //أتعاب الذكاه
            $table->unsignedBigInteger('other_fees')->nullable(); //أتعاب أخرى
            $table->unsignedBigInteger('total_fees')->nullable(); //اجمالى أتعاب
            $table->unsignedBigInteger('value_added_tax')->nullable();  //ضرائب القيمة المضافة
            $table->string('total_amount')->nullable(); //الأجمالى
            $table->string('status')->nullable(); //الحالة

            $table->foreignId('reviser_id')->nullable(); // المراجع الفنى
            $table->foreign('reviser_id')
                ->references('id')
                ->on('users');


            $table->foreignId('institution_id')->nullable(); //المنشأة طالبة المراجعة
            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
