<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DBGenerateSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:generate-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate JSON seeds from database';

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
        $seedsDir = 'database/seeds/sources/';

        //Get the tables
        $tables = DB::select('SHOW TABLES');
        
        //Loop through the tables and save their content in seperate JSON files
        foreach($tables as $table) {
            $tableName = $table->Tables_in_PepitoPizza;
            if($tableName !== 'migrations') {
                $rows = DB::select('SELECT * from ' . $tableName);
                file_put_contents($seedsDir . $tableName . '.json', json_encode($rows));
            }
        }
    }
}
