<?php

namespace App\Services\Webhooks;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use App\Models\Subscriber;

class WebhookUnsubscribe extends Webhook implements WebhookInterface{
    public $data;
    public $dataRules = [
        'client_id' => 'required',
        'date' => 'required|datetime'
    ];
      
    public function storeData () {
        $suscriptor = Subscriber::where('client_id', $this->data['client_id'])->where('status', 'ONLINE')->first();
        if(!$suscriptor) {
            throw new BadRequestException(json_encode('Suscriptor not found'), 409);
        }
        $parseData = $this->parseData($suscriptor);
        $suscriptor->update($parseData);
        return $suscriptor;
    }

    public function parseData ($suscriptor) {
        $data['unsubscribe_at'] = $this->data['date'];
        $data['status'] = 'DELETED';
        return $data;
    }
}
