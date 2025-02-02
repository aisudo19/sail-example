<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        $recipes = Recipe::select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.image', 'users.name')
            ->join('users', 'users.id', '=', 'recipes.user_id')
            ->orderBy('recipes.created_at', 'desc')
            ->limit(3)
            ->get();

        $popular =  Recipe::select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.views', 'recipes.image', 'users.name')
            ->join('users', 'users.id', '=', 'recipes.user_id')
            ->orderBy('recipes.views', 'desc')
            ->limit(2)
            ->get();

        // dd($popular);

        return view('home', compact('recipes', 'popular'));
    }

    public function index(Request $request)
    {
        $filters = $request->all();
        // dd($filters);
        $query =  Recipe::select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.views', 'recipes.image', 'users.name')
            ->join('users', 'users.id', '=', 'recipes.user_id')
            ->orderBy('recipes.created_at', 'desc');

        if (isset($filters)) {
            if (isset($filters['categories'])) {
                $query->whereIn('category_id', $filters['categories']);
            }
        }

        // if (isset($filters['rating'])) {
        //     $query->where('rating', '>=', $filters['rating']);
        // }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        $recipes = $query->get();
        // dd($recipes);

        $categories = Category::all();
        return view('recipes.index', compact('recipes', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}