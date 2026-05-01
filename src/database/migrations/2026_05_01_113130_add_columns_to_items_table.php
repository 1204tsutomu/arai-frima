<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('price'); // ブランド名（ Rolax など）
            $table->text('description')->nullable()->after('brand'); // 商品説明（スタイリッシュな... など）
            $table->foreignId('condition_id')->nullable()->constrained()->after('description'); // 商品の状態（外部キー）
            $table->foreignId('user_id')->nullable()->constrained()->after('condition_id'); // 出品者（外部キー）
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // 外した順番と逆に
            $table->dropForeign(['condition_id']);
            $table->dropColumn(['user_id', 'condition_id', 'description', 'brand']);
            //
        });
    }
}
