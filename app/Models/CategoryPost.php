<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryPost extends Model
{
    use HasFactory;
    protected $guared = [];
    protected $table = 'category_post';

    public $timestamps = false;
}