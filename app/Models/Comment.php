<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'comment',
        'user_id',
        'reply_id'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id');
    }
    // public function comment()
    // {
    //     return $this->belongsTo(Comment::class, 'reply_id');
    // }
    public function adminComment()
    {
        $user = User::where('email',$this->email)->first();
        return $user->admin;
    }
}
