<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $fillable =[
        'title',
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class,'blog_tags','tag_id','blog_id');
    }
}
