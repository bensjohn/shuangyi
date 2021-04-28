<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SySyCarInsure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_carInsure', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('车辆-保险记录更换表');
            $table->integer('carID')->nullable()->default(0)->index()->comment('租赁汽车编号');
            $table->integer('insureID')->nullable()->default(0)->index()->comment('当前保险编号');

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
