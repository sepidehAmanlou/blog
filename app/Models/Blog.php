<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    protected $table ='blogs';
    protected $fillable =[
        'title',
        'image',
        'description',
        'category_id',
        'status',
        'views',
    ];

     use SoftDeletes;
  protected $dates = ['deleted_at'];

    public function category()
    {

        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'blog_tags','blog_id','tag_id');
    }
}
