<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logins', function (Blueprint $table) {
            $table->id();
            $table->enum('action', ['Login', 'Signup', 'Logout'])->nullable();
            $table->enum('type', ['Website'])->nullable();
            $table->string('website', 100)->nullable();
            $table->longText('context');
            $table->timestamp('login_at')->useCurrent();

            $table->unsignedBigInteger('user_id')->nullable()->index();

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
        Schema::dropIfExists('user_logins');
    }
}
