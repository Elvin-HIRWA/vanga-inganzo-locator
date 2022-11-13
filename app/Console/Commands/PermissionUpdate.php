<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Console\Command;

class PermissionUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update permission';

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
        $id = $this->ask("Enter permission id");

        if (!is_numeric($id)) {
            $this->error("string is not required");
            return 1;
        }

        $permission = Permission::find($id);

        if ($permission === null) {
            $this->error("Id not exists");
            return 1;
        }

        $updatedName = $this->ask("Enter permission updated name");

        if (!$this->confirm("Do you wish to save?", true)) {
            $this->warn("You canceled to create update Permission");
            return 0;
        }

        
        $service->updatePermission($id, $updatedName);
        
        $this->info("permission name updated successfully");

        return 0;
    }
}
