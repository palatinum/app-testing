<?php

namespace App\Services\Webhooks;

use App\Models\Subscriber;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class WebhookSubscribe extends Webhook implements WebhookInterface{
    public $data;
    public $dataRules = [
        'client_id' => 'required',
        'date' => 'required|datetime',
        'email' => 'required|email',
    ];
      
    public function storeData () {
        $suscriptor = Subscriber::where('client_id', $this->data['client_id'])->where('status', 'ONLINE')->first();
        if($suscriptor) {
            throw new BadRequestException(json_encode('Online suscriptor'), 409);
        }
        $parseData = $this->parseData();
        $suscriptor = new Subscriber($parseData);
        $suscriptor->save();
        return $suscriptor;
    }

    public function parseData () {
        $data['client_id'] = $this->data['client_id'];
        $data['created_at'] = $this->data['date'];
        $data['email'] = $this->data['email'];
        return $data;
    }
}
