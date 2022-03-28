<?php

namespace Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class createUsersTable
{
    public function up()
    {
        Capsule::schema()->create('users', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('email', 50);
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->drop('users');
    }
}
