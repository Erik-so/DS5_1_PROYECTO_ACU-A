<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment_id',
        'publication_id'
    ];

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
    
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

}
