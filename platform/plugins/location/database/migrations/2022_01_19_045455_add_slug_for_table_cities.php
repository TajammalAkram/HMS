<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Botble\Location\Models\City;
use Illuminate\Support\Str;

class AddSlugForTableCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->string('slug', 120)->unique()->nullable();
        });
        $cities = City::get();

        foreach ($cities as $city) {
            $city->slug = create_city_slug(Str::slug($city->name), $city);
            $city->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['slug']);
        });
    }
}
