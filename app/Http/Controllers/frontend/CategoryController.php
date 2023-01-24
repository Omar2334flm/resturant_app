<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){

        $categories = Category::all();
        return  view ('categories.index', compact('categories'));
    }

    public function show(category $category){

           
        return view ('categories.show', compact('category'));
    }
}
