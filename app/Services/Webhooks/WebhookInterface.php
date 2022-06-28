<?php

namespace App\Services\Webhooks;

interface WebhookInterface {
    public function __construct(array $request);
    public function validateData();
    public function storeData();
}
