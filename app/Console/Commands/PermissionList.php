<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Console\Command;

class PermissionList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all permission';

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
        $permissions = $service->listPermission();

        $this->table(
            ['id', 'name'],
            $permissions
        );
    }
}
