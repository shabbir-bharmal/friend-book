<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relationship', function (Blueprint $table) {
            $table->integer('user_one_id')->unsigned()->index('user_one_id');
            $table->foreign('user_one_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->integer('user_two_id')->unsigned()->index('user_two_id');
            $table->foreign('user_two_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->enum('status',['0','1','2','3'])->comment("0-Pending,1-Accepted,2-Declined,3-Blocked");
            $table->integer('action_user_id')->unsigned()->index('action_user_id');
            $table->foreign('action_user_id')->references('id')->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('relationship');
    }
}
