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
            $table->foreignId('authorization_source_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('subject')
                ->index();
            $table->string('token', 8190);
            $table->string('refresh_token', 8190)
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
