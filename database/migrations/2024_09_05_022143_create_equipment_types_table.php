<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_types', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('th_name');
            $table->string('en_name');
            $table->timestamps();
        });

        $data = [
            ['th_name'=>'เมาส์ ', 'en_name'=>'mouse '],
            ['th_name'=>'คีย์บอร์ด ', 'en_name'=>'keyboard '],
            ['th_name'=>'จอมอนิเตอร์ ', 'en_name'=>'monitor '],
        ];

        \DB::table('equipment_types')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_types');
    }
}
