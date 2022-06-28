<?php

namespace App\Services\Webhooks;

use App\Models\Subscriber;
use App\Models\Billing;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;


class WebhookPayment extends Webhook implements WebhookInterface {
    public $data;
    public $dataRules = [
        'billing_id' => 'required',
        'client_id' => 'required',
        'date' => 'required|datetime',
        'status' => 'required',
        'amount' => 'required',
    ];
      
    public function storeData () {
        $suscriptor = Subscriber::where('client_id', $this->data['client_id'])->first();
        if(!$suscriptor) {
            throw new BadRequestException(json_encode('Suscriptor not found'), 409);
        }
        $billing = Billing::where('billing_id', $this->data['billing_id'])->where('status', $this->data['status'])->first();
        if($billing) {
            throw new BadRequestException(json_encode('Duplicate transaction'), 409);
        }
        $parseData = $this->parseData();
        $billing = new Billing($parseData);
        $billing->save();
        
        if($billing->status === 'OK') {
            $suscriptor->cumulative_total_charged += $billing->amount;
            $suscriptor->save();
        }
        return $billing;
    }
    
    public function calculateAmount () {
        
    }

    public function parseData () {
        $data['billing_id'] = $this->data['billing_id'];
        $data['client_id'] = $this->data['client_id'];
        $data['created_at'] = $this->data['date'];
        $data['status'] = $this->data['status'];
        $data['amount'] = $this->data['amount'];
        return $data;
    }
}
