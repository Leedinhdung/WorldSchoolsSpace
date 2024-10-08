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

    // Định nghĩa quan hệ với danh mục con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Hàm đệ quy để xây dựng cây danh mục
    public static function buildCategoryTree($categories, $parentId = null, $skipTrashedParent = false)
    {
        $branch = [];

        foreach ($categories as $category) {
            // Bỏ qua các danh mục cha bị xóa mềm nếu $skipTrashedParent là true
            if ($category->parent_id == $parentId) {
                if ($skipTrashedParent && $category->trashed()) {
                    // Nếu danh mục cha bị xóa mềm, tiếp tục lấy các con của nó
                    if (!empty($category->children)) {
                        $branch = array_merge($branch, self::buildCategoryTree($category->children, $category->id, true));
                    }
                    continue;
                }

                // Gọi đệ quy để lấy các danh mục con
                $children = self::buildCategoryTree($categories, $category->id, $skipTrashedParent);
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
