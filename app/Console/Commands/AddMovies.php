<?php

namespace App\Console\Commands;

use App\Models\Movie;
use Illuminate\Console\Command;

class AddMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-movies {json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add movies from movies.json';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $movies = json_decode(file_get_contents($this->argument('json')), true);
        $movies = array_map(function ($movie) {
            if (! $movie['release_date']) {
                $movie['release_date'] = null;
            } else {
                // e.g., 593395200
                $movie['release_date'] = date('Y-m-d H:i:s', $movie['release_date']);
            }

            $movie['genres'] = json_encode($movie['genres']);

            return $movie;
        }, $movies);
        // add $movies in 100 per chunk
        $chunks = array_chunk($movies, 200);
        $this->withProgressBar($chunks, function ($chunk) {
            Movie::insert($chunk);
        });
    }
}
