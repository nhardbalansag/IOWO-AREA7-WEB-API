<?php

namespace App\Http\Controllers\API\V1\Logs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use DateTime;

class LogsController extends Controller
{
    public function AddToInfoLog(Request $request){
        $data = [
            "user" => array(
                "user_id" => Auth::user()->id,
                "user_name" => Auth::user()->email,
            ),
            "log" => $request->log,
            "date" => Carbon::now()->format('d-m-Y H:i:s')
        ];

        Log::error($data);
    }
}
