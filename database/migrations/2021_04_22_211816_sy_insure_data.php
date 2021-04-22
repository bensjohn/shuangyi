<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyInsureData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_insureData', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('保险记录表');
            $table->integer('carID')->index()->comment('被保养车辆编号');
            $table->integer('insureDataID')->index()->comment('保险字典ID');
            $table->string('insureNumber')->nullable()->comment('保单号');
            $table->string('insureStartDate')->index()->nullable()->comment('保险起保时间');
            $table->string('insureEndDate')->index()->nullable()->comment('保险停保时间');
            $table->string('state')->nullable()->comment('状态 1在保2脱保3续保');
            $table->string('insureCost')->nullable()->comment('保险费用');
            $table->string('insureClass')->nullable()->comment('保险类型 1强险2商业险');
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
