<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Key;
use App\Services\PermissionService;
use Illuminate\Console\Command;

class PermissionDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete permission';

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
        $permissions = Permission::all(['id', 'name']);

        $this->table(
            ['id', 'name'],
            $permissions
        );
        $id = $this->ask("Enter permission id to delete");

        if (!is_numeric($id)) {
            $this->error("string is not required");
            return;
        }

        $permission = Permission::find($id);

        if ($permission === null) {
            $this->error("Permissin Id not exists");
            return;
        }

        $key = Key::where("permissionID", $id)->first();

        if ($key === null) {
            $service->deletePermission($id);
            $this->info("permission deleted successfully");
            return;
        }
        $this->error("you can't delete permission, is created on key ");
    }
}
