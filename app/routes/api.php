<?php

use App\Core\Route;

Route::add('webhook', 'WebhookController', 'handle', 'post');

Route::add('webhook/subscribe', 'WebhookSubscribeController', 'handle', 'post');
Route::add('webhook/unsubscribe', 'WebhookUnsubscribeController', 'handle', 'post');
Route::add('webhook/payment', 'WebhookPaymentController', 'handle', 'post');