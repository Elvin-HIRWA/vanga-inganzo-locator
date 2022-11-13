<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'userPermission:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List user with their permissions';

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
     * @return int
     */
    public function handle()
    {
        $users = User::getUsersWithTheirPermissions();

        $results = [];
       
            
        foreach ($users as $user => $value)
        {
            $results[$user] = (array) $value;
        }
        
        $this->table(['userEmail', 'permissionName'], $results);
    }
}
