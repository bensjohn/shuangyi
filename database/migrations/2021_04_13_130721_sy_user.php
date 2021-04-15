<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->index()->comment('姓名');
            $table->string('sex')->nullable()->comment('性别1男2女');
            $table->string('identity')->nullable()->index()->comment('证件号');
            $table->string('phone')->nullable()->index()->comment('手机号');
            $table->string('prepareMobilePhone')->nullable()->index()->comment('紧急预备电话');
            $table->string('address')->nullable()->index()->comment('地址');
            $table->string('email')->nullable()->index()->comment('电子邮箱');
            $table->string('job')->nullable()->comment('职位');
            $table->string('isDriveCar')->nullable()->comment('有无驾照');
            $table->string('driveNumber')->nullable()->index()->comment('驾照编号');
            $table->string('driveType')->nullable()->comment('驾驶证类型');
            $table->string('isBlack')->nullable()->comment('是否为黑名单');
            $table->string('back')->nullable()->comment('备注');
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
