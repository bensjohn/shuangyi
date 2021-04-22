<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyRepairData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('sy_repairData', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('维修记录表');
            $table->integer('carID')->index()->comment('维修车辆编号');
            $table->integer('giveCarID')->index()->comment('送修人用户ID 员工ID');
            $table->integer('repairID')->index()->comment('维修厂序号');
            $table->string('repairStartDate')->nullable()->comment('维修开始时间');
            $table->string('repairEndDate')->nullable()->comment('维修结束时间');
            $table->string('pickUpCarDate')->nullable()->comment('提车时间');
            $table->string('enterFactoryDate')->nullable()->comment('进场方式 1拖车2自驾');
            $table->string('reportContent')->nullable()->comment('司机报备内容');
            $table->string('checkResultClass')->nullable()->comment('检测结果类型 1司机2公司');
            $table->string('checkContent')->nullable()->comment('检测内容');
            $table->string('repairContent')->nullable()->comment('维修内容');
            $table->string('materialCost')->nullable()->comment('材料费');
            $table->string('peopleCost')->nullable()->comment('人工费');
            $table->string('otherCost')->nullable()->comment('其他费用');
            $table->string('totalCost')->nullable()->comment('总计费用');
            $table->string('leaveFactoryDate')->nullable()->comment('预计出厂时间');


            $table->integer('create_by')->nullable()->comment('创建人');
            $table->integer('update_by')->nullable()->comment('修改人');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
