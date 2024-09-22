<?php

use App\Models\Category;
use App\Models\User;
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
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title')->unique();
            $table->string('image');
            $table->string('slug')->unique()->comment('Đường dẫn');
            $table->longText('excerpt')->comment('Tóm tắt ngắn');
            $table->longText('content')->comment('Nội dung bài viết');
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('is_active')->default(0);
            $table->enum('status', ['pending', 'published']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};