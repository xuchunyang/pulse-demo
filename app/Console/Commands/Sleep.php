<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Sleep extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sleep';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sleep for [0.5, 1.5] seconds';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sleep = rand(5, 15) / 10;
        $this->info("Sleeping for {$sleep} seconds...");
        sleep($sleep);
        $this->info('Done!');
    }
}
