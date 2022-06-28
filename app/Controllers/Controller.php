<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

class Controller {
    protected $request;
    
    public function __construct() {
        $request = new Request();
        $this->request = $request->toArray();
    }
}
