<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RestartCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restart-cache {--restartdb}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('event:clear');
        $this->call('cache:clear');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('optimize:clear');
        $this->call('optimize');

        if ($this->option('restartdb')) {
            $this->call('migrate:fresh', ['--seed' => true]);
        }
    }
}
