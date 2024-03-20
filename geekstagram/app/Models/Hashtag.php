<?php

namespace App\Models;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashtag'
    ];

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }
    
}