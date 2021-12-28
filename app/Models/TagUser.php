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
}