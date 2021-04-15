<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sy_company', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index()->comment('公司名称');
            $table->string('address')->index()->comment('公司地址');
            $table->string('phone')->index()->comment('联系电话');
            $table->string('userName')->index()->comment('联络人名称');
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
