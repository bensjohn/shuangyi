<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyCarClassData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_carClassData', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('车辆字典');
            $table->integer('upperID')->nullable()->index()->comment('上游ID');
            $table->string('carRegisterDate')->nullable()->default('')->default('')->comment('车辆注册日期');
            $table->string('carFactory')->nullable()->default('')->comment('汽车厂家');
            $table->string('carBrand')->nullable()->default('')->comment('车辆品牌');
            $table->string('carName')->index()->nullable()->default('')->comment('车辆名称');
            $table->string('carModel')->nullable()->default('')->comment('车辆型号');
            $table->string('carClass')->nullable()->default('')->comment('车辆类型');
            $table->string('carColor')->nullable()->default('')->comment('车辆颜色');
            $table->string('status')->nullable()->default('')->comment('车辆使用性质 1营运2非营运3租赁');
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
