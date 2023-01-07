<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('보드 고유키값');
            $table->string('name', 20)->unique()->comment('보드명');
            $table->string('alias', 20)->unique()->comment('별칭');
            $table->string('description', 150)->nullable()->comment('보드 설명');
            $table->mediumText('custom_fields')->nullable()->comment('부가설정');
            $table->char('status', 10)->default('STABLE')->comment('상태값 (STABLE: 정상, STOP: 정지)');
            $table->timestamps();
            $table->softDeletes()->comment('삭제일시');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
};
