<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LegacyPurchaseMigrationService;

class MigrateLegacyPurchases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'legacy:migrate-purchases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate legacy purchases';

    /**
     * Execute the console command.
     */
    public function handle(LegacyPurchaseMigrationService $service)
    {
          $legacyPurchases = [
            [
                'item_name' => 'Sugar',
                'brand_name' => 'ABC',
                'qty' => 10,
                'price' => 100,
            ],
            [
                'item_name' => 'Tea',
                'brand_name' => 'XYZ',
                'qty' => 5,
                'price' => 200,
            ]
        ];

        $service->migrate($legacyPurchases);

        $this->info('Legacy purchases migrated successfully');
    
    }
}
