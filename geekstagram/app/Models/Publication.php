<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Hashtag;
use App\Models\User;
use App\Models\Sponsor;
use App\Models\PublicationComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'publication',
        'user_id',
        'like',
        'saved',
        'hashtag_id',
        'images',
        'comment',
        'sponsor'
    ];

    public function publicationComments()
    {
        return $this->hasMany(PublicationComment::class, 'publication_id');
    }
    
    public function comments()
    {
        return $this->hasManyThrough(Comment::class, PublicationComment::class, 'publication_id', 'id');
    }

    public function hashtag()
    {
        return $this->belongsTo(Hashtag::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sponsor(){
        return $this->belongsTo(Sponsor::class);
    }
}