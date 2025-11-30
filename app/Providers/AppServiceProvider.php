<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Google\Client;
use Google\Service\Drive;
use Masbug\Flysystem\GoogleDriveAdapter;
use League\Flysystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter; // <--- Import Ini Penting

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            Storage::extend('google', function($app, $config) {
                $client = new Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);
                
                // 1. Refresh Token
                $new_token = $client->fetchAccessTokenWithRefreshToken($config['refreshToken']);
                if (isset($new_token['error'])) {
                    throw new \Exception("Google Drive Error: " . json_encode($new_token));
                }
                $client->setAccessToken($new_token);

                // 2. Setup Driver
                $service = new Drive($client);
                $options = [];
                if (isset($config['teamDriveId'])) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }

                $adapter = new GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
                $driver = new Filesystem($adapter);

                // 3. WRAP DALAM LARAVEL ADAPTER (SOLUSI ERROR)
                // Ini membuat driver 'google' punya fitur lengkap Laravel (put, download, url, dll)
                return new FilesystemAdapter($driver, $adapter);
            });
        } catch (\Exception $e) {
            // Silent fail agar app tidak crash jika config salah
        }
    }
}