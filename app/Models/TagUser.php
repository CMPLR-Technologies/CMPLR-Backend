<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagUser extends Model
{
    use HasFactory;

    protected $primaryKey = ['tag_id', 'user_id'];
    public $incrementing = false;
}
