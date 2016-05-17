<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateWikiPagesLinksTable
 *
 * @author Kovács Vince<vincekovacs@hotmail.com>
 */
class CreateWikiPagesLinksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wiki_pages_links', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedInteger('page_id');
            $table->foreign('page_id')
                  ->references('id')
                  ->on('wiki_pages')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->unsignedInteger('refers_to_page_id')
                  ->nullable();
            $table->foreign('refers_to_page_id')
                  ->references('id')
                  ->on('wiki_pages')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->string('url');

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
        Schema::drop('wiki_pages_links');
    }
}
