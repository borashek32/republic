<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Flower;
use App\Models\Grass;
use App\Models\Tree;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = [
            [
                'title' => 'App\Models\Tree',
            ],
            [
                'title' => 'App\Models\Grass',
            ],
            [
                'title' => 'App\Models\Flower'
            ]
        ];

        $trees   = Tree::all();
        $flowers = Flower::all();
        $grasses = Grass::all();

        return view('dashboard.categories.index', compact('categories', 'flowers', 'trees', 'grasses'));
    }
}