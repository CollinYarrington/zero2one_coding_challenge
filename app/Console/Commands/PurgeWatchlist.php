<?php

namespace App\Console\Commands;

use App\Repositories\WatchlistRepository;
use Illuminate\Console\Command;

class PurgeWatchlist extends Command
{
    protected $watchlistRepository;
    public function __construct(WatchlistRepository $watchlistRepository)
    {
        parent::__construct();
        $this->watchlistRepository = $watchlistRepository;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purge:watchlist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command clears the watchlists table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->watchlistRepository->purgeWatchlist()) {
            $this->info('All watchlist items were purged');
        } else {
            $this->error('Failed to purge all watchlist items');
        }
    }
}
