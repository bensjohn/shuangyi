<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyCarData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_carData', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('车辆基本信息');
            $table->integer('carClassID')->nullable()->default(0)->comment('车辆字典ID');
            $table->integer('insureID')->nullable()->default(0)->comment('保险序号');
            $table->string('carNumber')->nullable()->default('')->comment('车牌号');
            $table->string('engineNumber')->nullable()->default('')->comment('发动机号');
            $table->string('carFrameNumber')->nullable()->default('')->comment('车架号');
            $table->string('carStatus')->nullable()->default('')->comment('当前车辆状态 1在库2出库');
            $table->string('shoeNum')->nullable()->default('')->comment('轮胎编码');
            $table->string('shoeSpecs')->nullable()->default('')->comment('轮胎规格');
            $table->string('powerType')->nullable()->default('')->comment('动力类型 1燃油2纯电3油电混合');
            $table->string('yearCheckDate')->nullable()->default('')->comment('年检日期');
            $table->string('keySum')->nullable()->default('')->comment('车钥匙数量');
            $table->string('isSend')->nullable()->default('')->comment('车辆行驶证是否已经发出 1是2否');

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
