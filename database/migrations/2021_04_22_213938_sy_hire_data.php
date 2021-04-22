<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyHireData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_hireData', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('租赁记录');
            $table->integer('userID')->index()->comment('租赁司机编号');
            $table->integer('carID')->index()->comment('租赁汽车编号');
            $table->integer('insureID')->index()->comment('当前保险编号');
            $table->integer('agentID')->index()->comment('经办人 员工ID');

            $table->string('hireType')->nullable()->comment('租赁模式 1月租2周租');
            $table->string('hireStartDate')->nullable()->comment('租赁时间');
            $table->string('hireEndDate')->nullable()->comment('还车时间');
            $table->string('hireLongTime')->nullable()->comment('租期 月为单位');
            $table->string('hireStartNumber')->nullable()->comment('租赁里程数');
            $table->string('hireEndNumber')->nullable()->comment('还车里程数');
            $table->string('hireStatus')->nullable()->comment('租赁状态 1租赁中2租赁完成');
            $table->string('accidentTime')->nullable()->comment('出险次数');
            $table->string('healthTime')->nullable()->comment('保养次数');
            $table->string('agentTime')->nullable()->comment('经办时间');
            $table->string('remark')->nullable()->comment('备注');

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
