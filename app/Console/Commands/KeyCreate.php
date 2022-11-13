<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permission;
use App\Models\Key;
use App\Services\KeyService;
use Firebase\JWT\JWT;
// use Firebase\JWT\Key;

class KeyCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'key create description';

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
        $permissions = Permission::all(['id', 'name']);

        $this->table(
            ['id', 'name'],
            $permissions
        );
        $id = $this->ask("Enter permission id");

        if (!is_numeric($id)) {
            $this->error("string is not required");
            return;
        }

        $permission = Permission::find($id);

        if ($permission === null) {
            $this->error("Id not exists");
            return;
        }

        $keyname = $this->ask("entering key name");
        if ($keyname === null) {
            $this->error("key must not be empty ");

            return 1;
        }

        $service->createKey($id, $keyname);

        $this->info('key created successfull ');

        return 0;

    }
}
