<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagUser extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'tag_name',
        'user_id',
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_name', 'name');
    }
}