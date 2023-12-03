<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q', '');
        $per_page = $request->query('per_page', 10);
        $builder = Movie::query();
        if ($q) {
            $builder
                ->where('title', 'like', "%{$q}%")
                ->orWhere('overview', 'like', "%{$q}%")
                ->orWhere('genres', 'like', "%{$q}%");
        }

        return Inertia::render('Movies', [
            'movies' => $builder->paginate($per_page)->withQueryString(),
            'q' => $q,
        ]);
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
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
