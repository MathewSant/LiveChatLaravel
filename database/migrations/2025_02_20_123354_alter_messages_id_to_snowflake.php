<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            // Remove o auto-increment e altera o tipo
            $table->unsignedBigInteger('id')->change();
            
            // Remove a primary key atual
            $table->dropPrimary();
            
            // Recria a primary key com o mesmo nome (opcional)
            $table->primary('id');
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            // Reverte para o estado original
            $table->dropPrimary();
            $table->bigIncrements('id')->change();
        });
    }
};