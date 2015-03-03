<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWikiPagesLinksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('wiki_pages_links', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->unsignedInteger('source_page_id');
            $table->foreign('source_page_id')
                ->references('id')
                ->on('wiki_pages')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('url');

            $table->unsignedInteger('target_page_id')
                ->nullable();
            $table->foreign('target_page_id')
                ->references('id')
                ->on('wiki_pages')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('wiki_pages_links');
    }
}
