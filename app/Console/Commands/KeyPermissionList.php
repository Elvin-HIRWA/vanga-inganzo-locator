<?php

namespace App\Console\Commands;

use App\Models\Key;
use App\Services\PermissionService;
use Illuminate\Console\Command;

class KeyPermissionList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keyPermission:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list all keys with their permissions';

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
    public function handle(PermissionService $service)
    {
        $keys = $service->keyPermission();

        $results = [];
            
        foreach ($keys as $key => $value)
        {
            $results[$key] = (array) $value;
        }
        
        $this->table(['Id', 'keyValue', 'permissionName'], $results);
    }
}
