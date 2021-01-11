<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthenticationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authentication_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('authorization_source_id')
                ->index();
            $table->foreign('authorization_source_id')
                ->references('id')
                ->on('authorization_sources');
            $table->string('nonce', 63)
                ->index();
            $table->string('status', 31)
                ->default('pending')
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
        Schema::dropIfExists('authentication_requests');
    }
}
