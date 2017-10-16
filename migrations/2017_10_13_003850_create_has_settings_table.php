<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHasSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('has_settings', function (Blueprint $table) {
            $table->increments('has_setting_id');

            $table->integer('foreign_id')->unsigned()->index();
            $table->string('foreign_model', 125)->index();

            $table->string('key')->index();
            $table->string('value');
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
        Schema::dropIfExists('has_settings');
    }
}
