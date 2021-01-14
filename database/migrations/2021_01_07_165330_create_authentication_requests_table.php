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
            $table->foreignId('authorization_source_id')
                ->constrained();
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
