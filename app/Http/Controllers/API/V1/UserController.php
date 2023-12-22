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

                    // get churches
                    $churches_information = DB::select(
                        '   SELECT
                                assigned_church_leaders.id as assigned_church_leaders_table_id,
                                churches.*
                            FROM assigned_church_leaders
                            JOIN churches ON assigned_church_leaders.church_id = churches.id
                            WHERE user_id = ?', [$user_info->id]);

                    $user_type = DB::select(
                        '   SELECT *
                            FROM user_categories
                            WHERE id = ?', [$user_info->user_category_id]);

                    $areaAndDistrict = DB::select(
                        '   SELECT districts.district_name, areas.area_name
                            FROM assigned_church_leaders
                            JOIN churches ON churches.id = assigned_church_leaders.church_id
                            JOIN district_areas ON district_areas.id = churches.district_area_id
                            JOIN districts ON districts.id = district_areas.district_id
                            JOIN areas ON areas.id = district_areas.area_id
                            WHERE user_id = ?', [$user_info->id]);

                    $res = [
                        "user_information" => $user_info,
                        "user_type" => $user_type,
                        "church_information" => $churches_information,
                        "churchDistrictAndArea_information" => $areaAndDistrict
                    ];

                    $this->response = [
                        'token' => $token,
                        'information' => $res,
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
