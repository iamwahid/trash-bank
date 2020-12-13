<?php

namespace App\Console\Commands;

use App\Repositories\Backend\WargaRepository;
use Illuminate\Console\Command;

class AdministrationPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:point-audit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly Point Audit';

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
        $repo = app(WargaRepository::class);
        $wargas = $repo->get();

        foreach ($wargas as $warga) {
            if ($repo->potongPoint($warga)) 
            $this->info("Biaya admin 10% ".$warga->name);
        }
    }
}
