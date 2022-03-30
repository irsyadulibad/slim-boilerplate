<?php

namespace Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class createPostsTable
{
    public function up()
    {
        Capsule::schema()->create('posts', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->drop('posts');
    }
}
