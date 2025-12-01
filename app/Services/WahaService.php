<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WahaService
{
    protected $baseUrl;
    protected $apiKey;
    protected $session;

    public function __construct()
    {
        $this->baseUrl = env('WAHA_BASE_URL', 'http://72.61.208.130:3000');
        $this->apiKey = env('WAHA_API_KEY', '0f0eb5d196b6459781f7d854aac5050e');
        $this->session = env('WAHA_SESSION', 'default');
    }

    public function sendText($phone, $message)
    {
        // 1. Format Nomor HP (Ubah 08xx jadi 628xx)
        $phone = preg_replace('/[^0-9]/', '', $phone); // Hapus karakter aneh
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        // Jika sudah 62, biarkan. Jika user input +62, regex di atas sudah menanganinya.

        // 2. Tambahkan suffix @c.us (Format standar WhatsApp ID)
        $chatId = $phone . '@c.us';

        // 3. Kirim Request ke WAHA
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey, // <--- Ini kuncinya
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/api/sendText", [
                'session' => $this->session,
                'chatId' => $chatId,
                'text' => $message,
            ]);

            // Cek jika WAHA merespon sukses
            if ($response->successful()) {
                return true;
            } else {
                // Jika gagal, catat di Log Laravel (storage/logs/laravel.log)
                Log::error('WAHA Error: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('WAHA Connection Error: ' . $e->getMessage());
            return false;
        }
    }
}