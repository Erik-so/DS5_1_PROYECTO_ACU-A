<?php

namespace App\Models;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'product_name',
        'price'
    ];
    public function publication()
    {
        return $this->hasOne(Publication::class);
    }
}
