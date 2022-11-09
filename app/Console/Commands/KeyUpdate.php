<?php

namespace App\Console\Commands;

use App\Models\Key;
use App\Models\Permission;
use App\Services\KeyService;
use Illuminate\Console\Command;
use Firebase\JWT\JWT;
// use Firebase\JWT\Key;

class KeyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update key value';

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
    public function handle(KeyService $service)
    {
        $keys = Key::all(['id', 'value']);

        $this->table(
            ['id', 'name'],
            $keys
        );
        $id = $this->ask("Enter key id");

        if (!is_numeric($id)) {
            $this->error("string is not required");
            return;
        }

        $key = Key::find($id);

        if ($key === null) {
            $this->error("Id not exists");
            return;
        }

        $keyname = $this->ask("enter key name to update ");
        if ($keyname === null) {
            $this->error("key must not be empty ");

            return;
        }
        $permissionID = $this->ask("Enter permission id");

        if (!is_numeric($permissionID)) {
            $this->error("string is not required");
            return;
        }

        $permission = Permission::find($permissionID);

        if ($permission === null) {
            $this->error("Id not exists");
            return;
        }
        $payload =  [
            "permissionID" => $permissionID,
            "timestamp" => time(),
        ];
        $jwt = JWT::encode($payload, $keyname, 'HS256');

        $service->updateKey($permissionID, $keyname, $id);

        // Key::where('id', $id)->update(['value' => $jwt]);
        $this->info("key value updated successfully");
    }
}
