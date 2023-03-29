<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title')->nullable();
            $table->string('short_code')->nullable();
            $table->tinyInteger('is_rtl')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();
        });
        DB::table('languages')->insert([
            [
                'short_code' => 'ar',
                'is_rtl' => '1',
                'title' => 'Arabic',
            ],
            [
                'short_code' => 'en',
                'is_rtl' => '0',
                'title' => 'English',
            ],
            [
                'short_code' => 'hi',
                'is_rtl' => '0',
                'title' => 'Hindi',
            ],
            [
                'short_code' => 'ru',
                'is_rtl' => '0',
                'title' => 'Russian',
            ],
            [
                'short_code' => 'ur',
                'is_rtl' => '1',
                'title' => 'Urdu',
            ]
        ]
    );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
