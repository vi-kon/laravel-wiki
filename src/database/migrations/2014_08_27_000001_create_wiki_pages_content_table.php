<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWikiPagesContentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('wiki_pages_content', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('title');
            $table->text('content');
            $table->unsignedInteger('views')
                ->default(0);
            $table->boolean('draft')
                ->default(true);

            $table->unsignedInteger('page_id');
            $table->foreign('page_id')
                ->references('id')
                ->on('wiki_pages')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedInteger('created_by_user_id');
            $table->foreign('created_by_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamp('created_at');
        });

        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('wiki_pages_content');
    }
}
