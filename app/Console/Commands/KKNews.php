<?php

namespace App\Console\Commands;

use App\Services\Works\KK;
use Illuminate\Console\Command;

class KKNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '刷新kk种子变动';

    /**
     * @var KK
     */
    protected $KK;

    /**
     * Create a new command instance.
     *
     * @param KK $KK
     */
    public function __construct(KK $KK)
    {
        parent::__construct();

        $this->KK = $KK;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->KK->generateNews();

        $this->comment('done!');
    }
}
