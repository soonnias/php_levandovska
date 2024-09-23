<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    public $timestamps = false; 
    protected $table = 'category_post'; 
    protected $fillable = ['category_id', 'post_id']; 

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
