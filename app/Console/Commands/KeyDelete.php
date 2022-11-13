<?php

namespace App\Console\Commands;

use App\Models\Key;
use App\Models\User;
use App\Services\KeyService;
use Illuminate\Console\Command;

class KeyDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete key';

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
            ['id', 'value'],
            $keys
        );
        $id = $this->ask("Enter key id to delete ");

        if (!is_numeric($id)) {
            $this->error("string is not required");
            return;
        }

        $key = Key::find($id);

        if ($key === null) {
            $this->error("Id not exists");
            return;
        }
        $userKeyID = User::where("keyID", $id)->first();

        if ($userKeyID === null) {
            $service->deleteKey($id);
            $this->info("key deleted successfully");
            return;
        }
        $this->error('you can not delete key is used by another user');
    }
}
