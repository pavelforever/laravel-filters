<?php 
namespace App\Services;

use App\Interfaces\PaymentGateway;

class Payment {
    protected $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway) {
        $this->paymentGateway = $paymentGateway;
    }

    public function pay($data) {
        return $this->paymentGateway->pay($data);
    }

    public function callback($data){
        return $this->paymentGateway->callback($data);
    }
}
