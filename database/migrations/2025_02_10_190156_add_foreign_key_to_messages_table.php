<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToMessagesTable extends Migration
{
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            // Caso a coluna 'user_id' já exista e você queira apenas definir a foreign key:
            $table->unsignedBigInteger('user_id')->nullable(); // ou sem nullable, conforme sua necessidade
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            // Remove a foreign key pelo nome da constraint (geralmente 'messages_user_id_foreign')
            $table->dropForeign(['user_id']);
        });
    }
}
