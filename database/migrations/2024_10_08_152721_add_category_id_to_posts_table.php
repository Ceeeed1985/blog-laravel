<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts_new', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt');
            $table->text('content');
            $table->string('thumbnail');
            $table->timestamps();
        });

        // S'assurer de sélectionner toutes les colonnes nécessaires
        DB::statement('INSERT INTO posts_new (id, category_id, title, slug, excerpt, content, thumbnail, created_at, updated_at) 
                       SELECT id, NULL AS category_id, title, slug, excerpt, content, thumbnail, created_at, updated_at 
                       FROM posts');

        Schema::drop('posts');
        Schema::rename('posts_new', 'posts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprime la table posts
        Schema::dropIfExists('posts'); 

        // Restaure la table posts_old
        Schema::create('posts_old', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt');
            $table->text('content');
            $table->string('thumbnail');
            $table->timestamps();
        });
    }
};
