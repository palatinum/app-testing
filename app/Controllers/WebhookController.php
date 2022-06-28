<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Services\Webhooks\WebhookSubscribe;
use App\Services\Webhooks\WebhookUnsubscribe;
use App\Services\Webhooks\WebhookPayment;
use App\Services\Webhooks\WebhookProcessor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;


class WebhookController extends Controller {
    
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
        switch ($this->request['type']) {
            case 'subscribe':
                $webhook = new WebhookSubscribe($this->request);
                break;
            case 'unsubscribe':
                $webhook = new WebhookUnsubscribe($this->request);
                break;
            case 'payment':
                $webhook = new WebhookPayment($this->request);
                break;
            default:
                $webhook = null;
                break;
        }
        return $webhook;
    }
}