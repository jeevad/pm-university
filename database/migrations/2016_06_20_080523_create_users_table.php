<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('api_token', 60)->unique();
            $table->string('full_name');
            $table->string('email')
                ->unique()
                ->index();
            $table->string('password');
            $table->integer('role_id')->unsigned();
            $table->boolean('activated')->default(false);
            $table->string('activation_code')->nullable();
            $table->boolean('news_letter_subscribed')->defalut(false);
            $table->integer('sign_in_channel_id')
                ->unsigned()
                ->default(1);
            $table->integer('sign_in_ip')
                ->unsigned()
                ->nullable();
            $table->boolean('logged_in')->default(false);
            $table->string('slug');

            // Timestamps
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
