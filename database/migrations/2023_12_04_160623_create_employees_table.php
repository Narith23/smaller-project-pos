<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Assuming a relationship with a 'users' table
            $table->string('firstName');
            $table->string('lastName');
            $table->string('name');
            $table->foreignId('position_id')->constrained(); // Assuming a relationship with a 'positions' table
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('birthdate')->default('2000-01-01');
            $table->string('gender')->nullable();
            $table->float('lat', 8, 2)->nullable();
            $table->float('long', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
