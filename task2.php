<?php

class Sales
{
    public function testPayment(array $data, $amount)
    {
        $payment = new PaypalPayment;
        try {
            $payment->validate($data, function($testAmount) use ($amount) {
                return $this->test($amount, $testAmount);
            });
        } catch (\PaypalException $e) {
            throw new \RuntimeException('something weird', 23, $e);
        }

        return $payment;
    }
}


class PaypalPayment
{
    private $testAmount = 200;

    public function validate(array $data, callable $comparator)
    {
        if (!$comparator->call($this, $this->testAmount)) {
            throw new \PaypalException("Incorrect amount");
        }
    }

    private function test($amount, $testAmount) {
        return $amount == $testAmount;
    }
}

class PaypalException extends Exception {}

(new Sales)->testPayment([], 200);