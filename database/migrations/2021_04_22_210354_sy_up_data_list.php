<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyUpDataList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_upDataList', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('上游记录');;
            $table->string('upperName')->nullable()->default('')->index()->comment('上游名称');
            $table->string('upAccidentName')->nullable()->default('')->comment('上游事故负责人');
            $table->string('upAccidentTel')->nullable()->default('')->comment('上游事故负责人电话');
            $table->string('upRepairName')->nullable()->default('')->comment('上游维修负责人');
            $table->string('upRepairTel')->nullable()->default('')->comment('上游维修负责人电话');
            $table->string('upHealthName')->nullable()->default('')->comment('上游保养负责人');
            $table->string('upHealthTel')->nullable()->default('')->comment('上游保养负责人电话');
            $table->string('upBreakRuleName')->nullable()->default('')->comment('上游违章负责人');
            $table->string('upBreakRuleTel')->nullable()->default('')->comment('上游违章负责人电话');
            $table->string('upCheckName')->nullable()->default('')->comment('上游年检负责人');
            $table->string('upCheckTel')->nullable()->default('')->comment('上游年检负责人电话');

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
