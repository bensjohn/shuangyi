<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyDriver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_driver', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index()->comment('姓名');
            $table->string('sex')->comment('性别1男2女');
            $table->string('identity')->index()->comment('证件号');
            $table->string('driverYear')->index()->comment('驾龄');
            $table->string('driverType')->index()->comment('驾照类别');
            $table->string('phone')->index()->comment('联系电话');
            $table->string('name2')->index()->comment('紧急联系姓名');
            $table->string('phone2')->index()->comment('紧急联系电话');
            $table->string('createBy')->index()->comment('创建人');
            $table->string('updateBy')->index()->comment('修改人');
            $table->string('back')->comment('备注');
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
