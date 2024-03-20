<?php

namespace App\Models;

use App\Models\Publication;
use App\Models\User;
use App\Models\PublicationComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image',
        'comment'
    ];

    public function publicationComment()
    {
        return $this->hasMany(PublicationComment::class, 'comment_id');
    }
    
    public function publications()
    {
        return $this->hasManyThrough(Publication::class, PublicationComment::class, 'comment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}