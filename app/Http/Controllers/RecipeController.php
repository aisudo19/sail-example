<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
        $query =  Recipe::select('recipes.id', 'recipes.title', 'recipes.description', 'recipes.created_at', 'recipes.views', 'recipes.image', 'users.name', DB::raw('AVG(reviews.rating) as rating'))
            ->join('users', 'users.id', '=', 'recipes.user_id')
            ->leftJoin('reviews', 'recipes.id', '=', 'reviews.recipe_id')
            ->groupBy('recipes.id')
            ->orderBy('recipes.created_at', 'desc');

        if (isset($filters)) {
            if (isset($filters['categories'])) {
                $query->whereIn('category_id', $filters['categories']);
            }
        }

        if (isset($filters['rating'])) {
            $query->havingRaw('AVG(reviews.rating) >= ' . $filters['rating']);
        }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        $recipes = $query->paginate(5);
        // dd($recipes);

        $categories = Category::all();
        return view('recipes.index', compact('recipes', 'categories', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('recipes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $posts = $request->all();
        $uuid = Str::uuid()->toString();

        Recipe::insert([
            'id' => $uuid,
            'title' => $posts['title'],
            'description' => $posts['description'],
            'category_id' => $posts['category'],
            'user_id' => Auth::id(),
        ]);

        $steps = [];
        foreach ($posts['steps'] as $key => $step) {
            $steps[$key] = [
                'recipe_id' => $uuid,
                'step_number' => $key + 1,
                'description' => $step,
            ];
        }

        Step::insert($steps);
        // dd($steps);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recipe = Recipe::with(['ingredients', 'steps', 'reviews.user', 'user'])
            ->where('recipes.id', $id)
            ->first();
        $recipe_record = Recipe::find($id);
        $recipe_record->increment('views');
        // dd($recipe);
        return view('recipes.show', compact('recipe'));
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