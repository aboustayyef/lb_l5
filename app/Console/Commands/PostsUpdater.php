<?php

namespace App\Console\Commands;

use App\Source;
use Illuminate\Console\Command;

class PostsUpdater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update_posts {source?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Database with New posts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // If a source is specified

        if ($this->argument('source')) {
                $source = Source::getByNickname($this->argument('source'));
            if ($source) {
                $this->info('Getting Latest Posts of Source: ' . $source->name );
                $source->updatePosts();
                $this->info('done');
                return;
            }
            throw new \Exception("Source [" . $this->argument('source') . "] not found", 1);
        }
        
        // If No source is specified, update all *Active* sources
        $sources = Source::where('active', 1)->get();
        $start_time = time();
        foreach ($sources as $source) {
            $this->comment('updating source ' . $source->name );
            try {
                $status = $source->updatePosts();
                $this->info($status);
            } catch (\Exception $e) {
                $this->error('There was an error updating this source');
            }
        }
        $end_time = time();
        $diff = $end_time - $start_time;
        $this->info('process took ' . $diff . ' seconds');
    }
}
