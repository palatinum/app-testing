<?php

namespace App\Services\Webhooks;

class WebhookProcessor {
    public function handle (WebhookInterface $webhook) {
        $webhook->validateData();
        return $webhook->storeData();
    }
}
