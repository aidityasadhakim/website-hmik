<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * 
 * @OA\Schema(
 *      title="Post",
 *      description="Post description for post data",
 *      required={"title","slug","body","image","category_id","user_id", "sub_category_id"},
 * )
 * 
 */

class Post extends Model
{

    /**
     * 
     * @OA\Property(
     *  description="Post TItle",
     *  property="title",
     *  type="string",
     *  format="string",
     * ),
     * @OA\Property(
     *  description="Post Slug",
     *  property="slug",
     *  type="string",
     *  format="string",
     * ),
     * @OA\Property(
     *  description="Category ID",
     *  property="category_id",
     *  type="string",
     *  format="string",
     * ),
     * @OA\Property(
     *  description="Body of Post",
     *  property="body",
     *  type="string",
     *  format="string",
     * ),
     * @OA\Property(
     *  description="file to upload",
     *  property="image",
     *  type="string",
     *  format="string",
     * ),
     * @OA\Property(
     *  description="User ID",
     *  property="user_id",
     *  type="string",
     *  format="string",
     * ),
     * @OA\Property(
     *  description="Sub Category ID",
     *  property="sub_category_id",
     *  type="string",
     *  format="string",
     * ),
     * 
     */

    use HasFactory, Sluggable;

    // protected $fillable = ['title', 'excerpt', 'body'];
    protected $guarded = ['id'];
    protected $with = ['category', 'author'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        $query->when($filters['sub_category'] ?? false, function ($query, $category) {
            return $query->whereHas('sub_category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) =>
            $query->whereHas(
                'author',
                fn ($query) =>
                $query->where('username', $author)
            )
        );
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategories()
    {
        return $this->belongsTo(SubCategories::class, 'sub_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
