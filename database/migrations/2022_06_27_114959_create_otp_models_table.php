<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otp_models', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('otp');
            $table->integer('try_count')->default(0);
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('otp_models');
    }
}
