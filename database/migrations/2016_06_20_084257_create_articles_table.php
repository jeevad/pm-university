<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('topic_id')
                ->unsigned()
                ->index();
            $table->integer('article_type_id')
                ->unsigned()
                ->index();
            $table->bigInteger('user_id')->unsigned();
            $table->string('source_url');
            $table->string('title');
            $table->longText('description');
            $table->bigInteger('file_id')
                ->unsigned()
                ->nullable();
            $table->string('author_name', 200)->nullable();
            $table->mediumText('author_description')->nullable();
            ;
            $table->bigInteger('author_picture_id')
                ->unusigned()
                ->nullable();
            $table->integer('sequence')->unsigned();
            $table->string('slug');
            
            // Timestamps
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            
            // Soft delete
            $table->softDeletes()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}