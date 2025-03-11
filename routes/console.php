<?php

use App\Console\Commands\PurgeWatchlist;
use Illuminate\Support\Facades\Schedule;

Schedule::command(PurgeWatchlist::class)->monthlyOn(1, '00:00');;
