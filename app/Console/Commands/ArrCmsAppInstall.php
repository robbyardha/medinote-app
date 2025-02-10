<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ArrCmsAppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arr-medinote-app-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install ARR Medinote App: Create database.sqlite and run migrations with seeding';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting ARR Medinote App installation...');

        $databasePath = database_path('database.sqlite');

        if (!File::exists($databasePath)) {
            File::put($databasePath, '');
            $this->info('database.sqlite file created.');
        } else {
            $this->info('database.sqlite file already exists.');
        }

        $this->updateEnv();

        $this->call('migrate:fresh', ['--seed' => true]);
        $this->info('ARR Medinote App installation completed successfully!');
    }

    /**
     * Update .env file for SQLite database configuration.
     *
     * @return void
     */
    private function updateEnv()
    {
        $envPath = base_path('.env');

        if (File::exists($envPath)) {
            $envContent = File::get($envPath);

            $envContent = preg_replace('/^DB_CONNECTION=.*$/m', 'DB_CONNECTION=sqlite', $envContent);
            $envContent = preg_replace('/^APP_URL=.*$/m', 'APP_URL=https://medinote-app.test', $envContent);
            // $envContent = preg_replace('/^DB_DATABASE=.*$/m', 'DB_DATABASE=' . database_path('database.sqlite'), $envContent);

            File::put($envPath, $envContent);
            $this->info('.env file updated for SQLite database.');
        } else {
            $this->error('.env file not found!');
        }
    }
}
