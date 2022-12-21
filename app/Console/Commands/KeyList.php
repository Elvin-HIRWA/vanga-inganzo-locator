<?php

namespace App\Console\Commands;

use App\Models\Key;
use App\Services\KeyService;
use Illuminate\Console\Command;

class KeyList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all keys';

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
        $keys = $service->listKey();

        $keys = array_map(function ($item) {

            $item = (array) $item;

            return $item;

        }, $keys);

        $this->table(
            ['id', 'value', 'permissionName'],
            (array)$keys
        );
    }
}
