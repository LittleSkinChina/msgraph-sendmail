<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return [
    App\Events\PluginWasEnabled::class => function () {
        if (!Schema::hasTable('ms_graph_tokens')) {
            Schema::create('ms_graph_tokens', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->nullable();
                $table->string('email')->nullable();
                $table->text('access_token');
                $table->text('refresh_token')->nullable();
                $table->string('expires');
                $table->timestamps();
            });
        }
    },
];
