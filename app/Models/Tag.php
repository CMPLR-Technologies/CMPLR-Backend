<?php

namespace App\Models;

use App\Models\User;
use App\Models\Posts;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function Posts()
    {
        return $this->belongsToMany(Posts::class, 'post_tags', 'post_id', 'tag_name');
    }
}