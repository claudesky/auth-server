<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')
                ->primary();
            $table->foreignId('user_id')
                ->nullable()
                ->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->string('ip_address', 45)
                ->nullable()
                ->index();
            $table->text('user_agent')
                ->nullable();
            $table->text('payload');
            $table->integer('last_login')
                ->unsigned()
                ->index();
            $table->integer('last_activity')
                ->unsigned()
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
