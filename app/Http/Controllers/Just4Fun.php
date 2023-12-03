<?php

namespace App\Http\Controllers;

use App\Jobs\RelaxAndHaveFun;

class Just4Fun extends Controller
{
    public function __invoke()
    {
        RelaxAndHaveFun::dispatch();

        return back()->with('status', '任务启动！Have fun!');
    }
}
