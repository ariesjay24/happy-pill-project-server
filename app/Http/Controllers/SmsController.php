<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SemaphoreService;

class SmsController extends Controller
{
    protected $semaphoreService;

    public function __construct(SemaphoreService $semaphoreService)
    {
        $this->semaphoreService = $semaphoreService;
    }

    public function sendSms(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'message' => 'required'
        ]);

        $result = $this->semaphoreService->sendSms($request->number, $request->message);

        return response()->json($result);
    }
}
