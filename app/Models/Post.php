<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'post';
    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    } 
    public function categoriesID()
    {
        $categoriesID = [];
        foreach($this->category as $category){
            array_push($categoriesID,$category->id);
        }
        return $categoriesID;
    } 

}