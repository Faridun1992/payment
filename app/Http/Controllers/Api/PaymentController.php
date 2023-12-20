<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\HandleCallbackFirstRequest;
use App\Http\Requests\Api\HandleCallbackSecondRequest;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function __construct(
        public PaymentService $service
    )
    {
    }

    public function handleCallbackFirst(HandleCallbackFirstRequest $request): JsonResponse
    {
        if ($this->service->validateSignature($request->validated())) {
            if (!$this->service->checkDailyLimit('FIRST_GATEWAY_LIMIT', $request->input('amount'))) {
                return response()->json(['info' => 'Daily limit exceeded']);
            }
            //тут можно обновлять платеж согласно обновленным данным
            return response()->json(['info' => 'Callback processed successfully']);
        }

        return response()->json(['info' => 'Invalid signature in callback']);
    }

    public function handleCallbackSecond(HandleCallbackSecondRequest $request): JsonResponse
    {
        if ($this->service->validateHash($request->validated())) {
            if (!$this->service->checkDailyLimit('SECOND_GATEWAY_LIMIT', $request->input('amount'))) {
                return response()->json(['info' => 'Daily limit exceeded']);
            }
            //тут можно обновлять платеж согласно обновленным данным
            return response()->json(['info' => 'Callback processed successfully']);
        }

        return response()->json(['info' => 'Invalid signature in callback']);
    }
}
