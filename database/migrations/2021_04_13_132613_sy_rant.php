<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyRant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_rant', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index()->comment('租赁人员id');
            $table->string('target')->comment('人员来源 1司机2员工');
            $table->string('number')->index()->comment('车辆编号');
            $table->string('isChange')->comment('是否需要换租');
            $table->string('keyNum')->comment('领取的车钥匙数量');
            $table->string('carInfo')->comment('出车信息');
            $table->string('isReturn')->comment('是否归还');
            $table->string('startTime')->index()->comment('租赁起始日');
            $table->string('endTime')->index()->comment('租赁结束日');

            $table->string('uid')->comment('操作uid');
            $table->softDeletes();
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
        //
    }
}
