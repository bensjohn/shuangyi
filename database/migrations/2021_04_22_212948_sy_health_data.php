<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyHealthData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_healthData', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('保养记录');
            $table->integer('carID')->nullable()->default(0)->index()->comment('车辆编号');
            $table->integer('userID')->nullable()->default(0)->index()->comment('司机编号 用户ID');

            $table->string('healthContent')->nullable()->default('')->comment('保养内容');
            $table->string('payer')->nullable()->default('')->comment('付款方 1上游支付2公司自费');
            $table->string('healthCost')->nullable()->default('')->comment('保养费用');
            $table->string('lastTimeHealthNumber')->nullable()->default('')->comment('上次保养公里数');
            $table->string('healthNumber')->nullable()->default('')->comment('保养里程数');
            $table->string('healthDate')->nullable()->default('')->comment('保养时间');
            $table->string('nextTimeKeep')->nullable()->default('')->comment('下次保养公里数');
            $table->string('remark')->nullable()->default('')->comment('备注');

            $table->integer('create_by')->nullable()->default(0)->comment('创建人');
            $table->integer('update_by')->nullable()->default(0)->comment('修改人');
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
