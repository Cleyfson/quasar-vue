<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function logApi(Request $request) {
        $message = $request->msg;
        Log::info($message);
    }
    public function logWarn(Request $request) {
        $message = $request->msg;
        Log::warning($message);
    }
    public function logError(Request $request) {
        $message = $request->msg;
        Log::error($message);
    }
}
