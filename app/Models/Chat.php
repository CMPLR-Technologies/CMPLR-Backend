<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_blog_id',
        'to_blog_id',
        'content',
        'is_read'
    ];
    public function sender()
    {
        return $this->belongsTo(Blog::class ,'from_blog_id' );
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_blog_id');
    }
    public function ScopeBySender($q, $sender)
    {
        $q->where('from_blog_id', $sender);
    }
    public function scopeByReceiver($q, $sender)
    {
        $q->where('to_blog_id', $sender);
    }

}
