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
        Schema::create('board_items', function (Blueprint $table) {
            $table->id()->comment('게시물 고유키값');
            $table->foreignId('board_id')->references('id')->on('boards')->onUpdate('cascade')->onDelete('cascade')->comment('보드 고유키값');
            $table->foreignId('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade')->comment('작성자 고유키값');
            $table->string('title')->comment('게시물 제목');
            $table->mediumText('contents')->comment('게시물 본문');
            $table->boolean('is_hidden')->default(0)->comment('비밀글 (true: 비밀글, false: 설정안함)');
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
        Schema::dropIfExists('board_items');
    }
};
