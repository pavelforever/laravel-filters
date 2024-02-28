<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('imagePreview');
            $table->string('title');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('posts', function (Blueprint $table) {
        //     $table->dropColumn('imagePreview');
        // });
        Schema::table('post_tags', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
        });
    
        Schema::dropIfExists('posts');
    }
};
