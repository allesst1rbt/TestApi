<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    protected $casts = [
        'created' => 'datetime:d/m/Y H:m:s'
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Products', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable(false);
            $table->string('type')->nullable(false);
            $table->text('description')->nullable(false);
            $table->string('filename')->nullable(false);
            $table->integer('height')->nullable(false);
            $table->integer('width')->nullable(false);
            $table->float('price')->nullable(false);
            $table->integer('rating')->nullable(false);
            $table->timestamp('created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(["title", "type"], 'items_combination_unique');
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
}
