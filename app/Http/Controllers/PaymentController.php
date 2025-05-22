<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $title = $request->input('title');
        $amount = $request->input('amount');

        $response = $this->paymentService->createOrder($title, $amount);

        return response()->json($response);
    }
}
