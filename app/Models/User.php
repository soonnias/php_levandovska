<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable; 

class User extends Model implements AuthenticatableContract
{ 
    use HasFactory, Authenticatable; 

    protected $primaryKey = 'user_id';
    protected $fillable = ['username', 'email', 'password', 'role'];
    protected $hidden = ['password'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    // Додатковий метод для отримання ролі
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}

