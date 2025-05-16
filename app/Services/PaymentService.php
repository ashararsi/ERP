<?php

namespace App\Services;

use App\Models\Payment;

class PaymentService extends BaseService {
    
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }
}