<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'tag_users', 'tag_id', 'user_id');
    }
}
