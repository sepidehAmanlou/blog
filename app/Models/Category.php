<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{ 
    use HasFactory;
    protected $fillable =[

        'title',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
