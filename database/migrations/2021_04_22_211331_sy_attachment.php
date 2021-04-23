<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyAttachment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_attachment', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('附件id');
            $table->string('tableName')->nullable()->default('')->comment('关联表');
            $table->integer('tableNameId')->nullable()->default(0)->index()->comment('关联表Id');
            $table->string('name')->index()->nullable()->default('')->comment('附件名');
            $table->string('path')->index()->nullable()->default('')->comment('路径');
            $table->string('type')->nullable()->default('')->comment('类型 1行驶证2车辆照片3保险文件或者图片4维修文件/照片5现场文件/照片6里程数照片7违章内容(图片)7身份证正面照片8身份证背面照片8驾驶证照片9驾驶证副本照片10违章处理截图');
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
