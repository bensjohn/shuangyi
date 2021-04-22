<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyRepairClassData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_repairClassData', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('维修厂字典');
            $table->string('repairName')->index()->nullable()->comment('维修厂名称');
            $table->string('repairAddress')->nullable()->comment('维修厂地址');
            $table->string('repairManagerName')->nullable()->comment('维修厂经理名称');
            $table->string('repairManagerTel')->nullable()->comment('维修厂经理电话');
            $table->string('status')->nullable()->comment('当前维修厂状态 1合作中2解除合作');

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
