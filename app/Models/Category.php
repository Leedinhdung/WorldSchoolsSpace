<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'parent_id',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Lấy danh mục con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Lấy danh mục cha
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Hàm đệ quy để xây dựng cây danh mục
    public static function buildCategoryTree($categories, $parentId = null)
    {
        $branch = [];
        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $children = self::buildCategoryTree($categories, $category->id);
                if ($children) {
                    $category->children = $children;
                }
                $branch[] = $category;
            }
        }
        return $branch;
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
