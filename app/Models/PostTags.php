<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = [
        'post_id',
        'tag_name',
    ];

    public function post ()
    {
        return $this->belongsTo(Posts::class);
    }

}
