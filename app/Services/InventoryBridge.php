<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class InventoryBridge
{
    protected string $url;
    protected string $token;

    public function __construct()
    {
        $this->url = config('services.inventree.url');
        $this->token = config('services.inventree.token');
    }

    public function addPartToInventory(array $partData)
    {
        return Http::withToken($this->token)
            ->post("{$this->url}/api/part/", [
                'name' => $partData['name'],
                'description' => $partData['description'],
                'IPN' => $partData['part_number'], // Internal Part Number
                'active' => true,
            ]);
    }
}