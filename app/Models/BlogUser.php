<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogUser extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'blog_id',
        'primary',
        'full_privileges',
        'contributor_privileges'
    ];

}
