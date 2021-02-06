<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//  Classe para renomear campo 'bedhrooms' para 'bedrooms' na tabela 'real_state'

class RenameBedhroomsInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_state', function (Blueprint $table) {
            $table->renameColumn('bedhrooms', 'bedrooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('real_state', function (Blueprint $table) {
            $table->renameColumn('bedrooms', 'bedhrooms');
        });
    }
}
