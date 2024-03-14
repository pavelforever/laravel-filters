<?php 

namespace App\Interfaces;


interface PaymentGateway {
    public function pay($data);
    public function callback($data);
};