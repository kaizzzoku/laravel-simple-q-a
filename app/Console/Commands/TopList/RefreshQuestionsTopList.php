<?php

namespace App\Console\Commands\TopList;

use Illuminate\Console\Command;
use App\Services\TopList\Managers\QuestionsTopListManager;

class RefreshQuestionsTopList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'top_lists:refresh_questions';

    /**
     * The console command description.
     *
     * @var stringTop lists Builders aren't dependent on Managers now
     */
    protected $description = 'Refresh top list for questions';

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
    public function handle(QuestionsTopListManager $manager)
    {
        $manager->refresh();
        info("Questions top list refreshed in ". now());
    }
}
