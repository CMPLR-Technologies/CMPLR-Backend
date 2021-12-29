<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostNotes extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }


    public function post_notes_count()
    {
        $result = PostNotes::where('post_id', $this->post_id)->select('type', DB::raw('count(*) as total'))->groupBy('type')->get();
        $counts = array(
            'like' => 0,
            'reply' => 0,
            'reblog' => 0
        );
        foreach ($result as $count) {
            $counts[$count->type] = $count->total;
        }


        return $counts;
    }

    protected $fillable = [
        'user_id',
        'post_id',
        'type',
        'content',
    ];
}
