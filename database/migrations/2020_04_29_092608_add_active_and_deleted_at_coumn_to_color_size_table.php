<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveAndDeletedAtCoumnToColorSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('color_size', function (Blueprint $table) {
            $table->boolean('active')->after('order')->default(1);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('color_size', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('deleted_at');

        });
    }
}
