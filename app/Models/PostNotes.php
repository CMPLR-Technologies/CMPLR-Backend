<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostNotes extends Model
{
    use HasFactory;

    public function user ()
    {
        return $this->belongsTo(User::class );
    }

    public function post ()
    {
        return $this->belongsTo(Post::class);
    }

    

    
    protected $fillable = [
        'user_id',
        'post_id',
        'type',
        'content',
    ];
}
