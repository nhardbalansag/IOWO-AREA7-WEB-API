<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;

use App\Models\User;

class UserController extends Controller
{
    public $response = [];

    public function login(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:3']
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();

                $this->response = [
                    'token' => null,
                    'information' => null,
                    'status' => false,
                    'errors' => $errors
                ];

                return response()->json($this->response, 422); // 422 Unprocessable Entity - Validation Error
            }

            $user = DB::table('users')
                    ->where('email', $request->email)
                    ->first();

            if(!empty($user)){
                $enteredPassword = $request->password;
                $enteredEmail = $request->email;

                $DBpassword = $user->password;
                $DBemail = $user->email;

                $password = Hash::check($enteredPassword, $DBpassword);
                $user_info = User::where('email', $request->email)->first();

                if($password && $enteredEmail === $DBemail){
                    $token = $user_info->createToken('authToken')->accessToken;

                    $this->response = [
                        'token' => $token,
                        'information' => $user_info,
                        'status' => true,
                        'error' => null
                    ];
                }else if(!$password){
                    $this->response = [
                        'token' => null,
                        'information' => null,
                        'status' => false,
                        'error' => [
                            "incorrect" => ["login failed."]
                        ]
                    ];
                }
            }else{
                $this->response = [
                    'token' => null,
                    'information' => null,
                    'status' => false,
                    'error' => [
                        "authentication" => ["The user is not exist."]
                    ]
                ];
            }

            return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } catch (Exception $exception) {
            $this->response = [
                'token' => null,
                'information' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }
}
