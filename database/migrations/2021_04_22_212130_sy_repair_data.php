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
            $table->integer('carID')->nullable()->default(0)->index()->comment('维修车辆编号');
            $table->integer('giveCarID')->nullable()->default(0)->index()->comment('送修人用户ID 员工ID');
            $table->integer('repairID')->nullable()->default(0)->index()->comment('维修厂序号');
            $table->string('repairStartDate')->nullable()->default(0)->comment('维修开始时间');
            $table->string('repairEndDate')->nullable()->default('')->comment('维修结束时间');
            $table->string('pickUpCarDate')->nullable()->default('')->comment('提车时间');
            $table->string('enterFactoryDate')->nullable()->default('')->comment('进场方式 1拖车2自驾');
            $table->string('reportContent')->nullable()->default('')->comment('司机报备内容');
            $table->string('checkResultClass')->nullable()->default('')->comment('检测结果类型 1司机2公司');
            $table->string('checkContent')->nullable()->default('')->comment('检测内容');
            $table->string('repairContent')->nullable()->default('')->comment('维修内容');
            $table->string('materialCost')->nullable()->default('')->comment('材料费');
            $table->string('peopleCost')->nullable()->default('')->comment('人工费');
            $table->string('otherCost')->nullable()->default('')->comment('其他费用');
            $table->string('totalCost')->nullable()->default('')->comment('总计费用');
            $table->string('leaveFactoryDate')->nullable()->default('')->comment('预计出厂时间');


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
