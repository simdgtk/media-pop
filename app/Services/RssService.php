<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class RssService
{
    public function fetch(string $url): array
    {
        try {
            $response = Http::withoutVerifying()->get($url);

            if ($response->successful()) {
                $xml = new SimpleXMLElement($response->body());
                $items = [];

                foreach ($xml->channel->item as $item) {
                    $items[] = [
                        'title' => (string) $item->title,
                        'link' => (string) $item->link,
                        'description' => (string) $item->description,
                    ];
                }

                return $items;
            }
        } catch (\Exception $e) {
            return [];
        }

        return [];
    }
}
