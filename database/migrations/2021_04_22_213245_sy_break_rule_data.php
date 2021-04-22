<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyBreakRuleData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_breakRuleData', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('违章记录');
            $table->integer('carID')->index()->comment('违章车辆编号');
            $table->integer('userID')->index()->comment('司机编号 用户ID');
            $table->integer('dealID')->index()->comment('经办人ID 用户ID');

            $table->string('dealDate')->nullable()->comment('经办时间');
            $table->string('reduceGrade')->nullable()->comment('扣分数');
            $table->string('fineCost')->nullable()->comment('罚款费用');
            $table->string('dealClass')->nullable()->comment('处理方式 1公司处理2驾驶人处理');
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
