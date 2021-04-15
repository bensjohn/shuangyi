<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyCar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_car', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brand')->index()->comment('车辆品牌');
            $table->string('name')->index()->comment('车辆名称');
            $table->string('type')->index()->comment('车辆类型');
            $table->string('color')->index()->comment('车辆颜色');
            $table->string('deposit')->index()->comment('押金');
            $table->string('rentalPrice')->index()->comment('租赁价格');
            $table->string('state')->comment('状态 1在库2不在库');
            $table->string('licenseType')->index()->comment('车牌类型');
            $table->string('licenseNumber')->index()->comment('车牌号');
            $table->integer('companyId')->index()->comment('上游公司id');
            $table->string('keyNum')->comment('钥匙数量');
            $table->string('isSent')->comment('车辆行驶证是否已经发出');
            $table->string('maintainKm')->comment('保养里程 km');
            $table->string('alreadyKm')->comment('已行驶公里数 km');
            $table->string('alreadyMaintainKm')->comment('已保养次数');
            $table->string('checkData')->comment('年检日期');
            $table->string('uid')->comment('操作uid');
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
