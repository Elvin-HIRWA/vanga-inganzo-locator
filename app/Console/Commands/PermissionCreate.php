<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Console\Command;

class PermissionCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new permission';

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
        $name = $this->ask("Enter permission name");

        if (!$this->confirm("Do you wish to save?", true)) {
            $this->warn("You canceled to create new Permission");
            return 0;
        }

        $service->CreatePermission($name);
        
        $this->info("permission name added successfully");

        return 0;
    }
}
