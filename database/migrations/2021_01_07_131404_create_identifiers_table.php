<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identifiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('authorization_source_id')
                ->index();
            $table->unsignedBigInteger('user_id')
                ->nullable()
                ->index();
            $table->string('token');
            $table->string('refresh_token')
                ->nullable();
            $table->string('full_name')
                ->nullable();
            $table->string('first_name')
                ->nullable()
                ->index();
            $table->string('last_name')
                ->nullable()
                ->index();
            $table->string('middle_name')
                ->nullable()
                ->index();
            $table->string('email')
                ->nullable()
                ->index();
            $table->json('content');
            $table->string('status')
                ->nullable()
                ->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identifiers');
    }
}
