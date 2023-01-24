<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\category;
class menu extends Model
{
    use HasFactory;

           

    protected $fillable=['name' ,'image' ,'description' ,'price'];
    public function categories(){
        
        return $this->belongsToMany(Category::class);

    }
}
