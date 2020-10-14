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
    ];
    public function post()
    {
        $this->belongsTo(Post::class);
    }
    public function adminComment()
    {
        $user = User::where('email',$this->email)->first();
        return $user->admin;
    }
}
