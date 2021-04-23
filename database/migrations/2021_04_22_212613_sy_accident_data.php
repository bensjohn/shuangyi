<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyAccidentData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_accidentData', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('事故记录');
            $table->integer('carID')->nullable()->default(0)->index()->comment('事故车辆编号');
            $table->integer('accidentManagerID')->nullable()->default(0)->index()->comment('事故负责人ID 员工ID');
            $table->integer('insureID')->nullable()->default(0)->index()->comment('保险编号');

            $table->string('accidentDate')->nullable()->default('')->comment('事故时间');
            $table->string('accidentAddress')->nullable()->default('')->comment('事故地点');
            $table->string('dealDate')->nullable()->default('')->comment('处理时间');
            $table->string('accidentReason')->nullable()->default('')->comment('事故原因');
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
