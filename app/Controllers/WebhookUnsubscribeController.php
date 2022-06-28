<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Services\Webhooks\WebhookUnsubscribe;
use App\Services\Webhooks\WebhookProcessor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;


class WebhookUnsubscribeController extends Controller {
    
    public function handle () {
        $this->validateWebhook();
        $webhook = $this->getWebhook();
        $webhookProcessor = new WebhookProcessor();
        $response = $webhookProcessor->handle($webhook);
        $response = new JsonResponse($response, 200);
        $response->send();
        exit();
    }

    private function validateWebhook () {
        if (!isset($this->request['type']) || empty($this->request['type'])) {
            throw new BadRequestException('Missing type field', 400);
        }
        
        if (!isset($this->request['data']) || empty($this->request['data'])) {
            throw new BadRequestException('Missing data field', 400);
        }
    }

    private function getWebhook () {
        return new WebhookUnsubscribe($this->request);
    }
}