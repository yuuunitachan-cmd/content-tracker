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
        Schema::table('postingan', function (Blueprint $table) {
            $table->index('created_at', 'postingan_created_at_index');
            $table->index('sumber_konten_id', 'postingan_sumber_idx');
            $table->index('jenis_konten_id', 'postingan_jenis_idx');
            $table->index('tagar', 'postingan_tagar_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postingan', function (Blueprint $table) {
            $table->dropIndex('postingan_created_at_index');
            $table->dropIndex('postingan_sumber_idx');
            $table->dropIndex('postingan_jenis_idx');
            $table->dropIndex('postingan_tagar_idx');
        });
    }
};
