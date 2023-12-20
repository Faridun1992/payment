<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class PaymentService
{
    public function validateSignature(array $data): bool
    {
        $signature = $data['sign'];

        unset($data['sign']);

        ksort($data);

        $dataString = implode(':', $data) . ':' . env('MERCHANT_KEY');

        $hashedData = hash('sha256', $dataString);

        return $hashedData === $signature;
    }

    public function validateHash(array $data): bool
    {
        $dataString = implode('.', [
            'project=' . $data['project'],
            'invoice=' . $data['invoice'],
            'status=' . $data['status'],
            'amount=' . $data['amount'],
            'amount_paid=' . $data['amount_paid'],
            'rand=' . $data['rand'],
        ]);

        $dataString .= env('APP_PAYMENT_KEY');

        $hashedData = md5($dataString);

        return $hashedData === request()->header('Authorization');
    }

    public function checkDailyLimit($gateway, $amount): bool
    {
        $cacheKey = "daily_limit_{$gateway}";

        $dailyTotal = Cache::get($cacheKey, 0);

        if (($dailyTotal + $amount) > env($gateway)) {
            return false;
        }

        Cache::put($cacheKey, $dailyTotal + $amount, now()->endOfDay());

        return true;
    }
}
