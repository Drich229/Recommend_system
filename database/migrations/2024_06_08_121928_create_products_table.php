<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->text('description');
            $table->integer('stock')->default(1);
            $table->string('image');
            $table->string('categories');
            $table->boolean('manche_longue')->default(false);
            $table->boolean('manche_courte')->default(false);
            $table->boolean('a_enfiler')->default(false);
            $table->boolean('col_rond')->default(false);
            $table->boolean('bouton')->default(false);
            $table->boolean('col_v')->default(false);
            $table->boolean('ras_du_cou')->default(false);
            $table->boolean('coton')->default(false);
            $table->boolean('avec_col')->default(false);
            $table->boolean('polyester')->default(false);
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
        Schema::dropIfExists('products');
    }
};
