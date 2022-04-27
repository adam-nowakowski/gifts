<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking_days', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('reservations');
            $table->json('bookings_ids');
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_days');
    }
};
