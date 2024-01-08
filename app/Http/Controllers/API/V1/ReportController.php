<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;
use DateTime;

use Illuminate\Support\Facades\Mail;
use App\Mail\AreaOverseer;


use App\Models\V1\Activity\Activity;
use App\Models\V1\GeneratedDocument\GeneratedDocument;

class ReportController extends Controller
{

    public $response = [];

    // admin access level and delete access type
    public function DeletePDFReport(Request $request){
        try{

            $result = DB::table('generated_documents')->where('user_id', Auth::user()->id)->where('id', $request->pdf_id)->update(['is_deleted' => true]);

            $this->response = [
                'data' => $result,
                'status' => true,
                'error' => null
            ];

            return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Pastors per church
    public function CreateActivityReport(Request $request){
        try{

            $count = DB::table('activities')
                    ->where('user_id', Auth::user()->id)
                    ->where('activity_date', Carbon::parse($request->activity_date)->format('Y-m-d'))
                    ->count();

            if ($count > 0) {

                $this->response = [
                    'data' => null,
                    'status' => false,
                    'error' => "exist"
                ];

                return response()->json($this->response, 422); // 422 Unprocessable Entity - Validation Error
            }else{
                $result = Activity::create([
                    'user_id' => Auth::user()->id,
                    'activity_category_id' => $request->activity_category_id,

                    'adult_attendance_count' => $request->adult_attendance_count,
                    'youth_attendance_count' => $request->youth_attendance_count,
                    'children_attendance_count' => $request->children_attendance_count,

                    'tithes' => $request->tithes,
                    'total_tithes' => $request->total_tithes,
                    'total_offering' => $request->total_offering,
                    'gospel_seed' => $request->gospel_seed,
                    'personal_tithes' => $request->personal_tithes,

                    'new_bible_studies_count' => $request->new_bible_studies_count,
                    'existing_bible_studies_count' => $request->existing_bible_studies_count,

                    'received_jesus_count' => $request->received_jesus_count,

                    'water_baptized_count' => $request->water_baptized_count,
                    'holy_spirit_baptized_count' => $request->holy_spirit_baptized_count,

                    'children_dedication_count' => $request->children_dedication_count,
                    'healed_count' => $request->healed_count,

                    'testimonies_miracles_details' => $request->testimonies_miracles_details,
                    'activity_date' => Carbon::parse($request->activity_date)->format('Y-m-d'),
                    'remarks' => $request->remarks
                ]);

                $this->response = [
                    'data' => $result,
                    'status' => true,
                    'error' => null
                ];

                return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            }
        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Pastors per church
    public function RequestEditActivityReport(Request $request){
        try{

            $exists = DB::table('activities')
                    ->where('user_id', Auth::user()->id)
                    ->where('id', $request->activity_id)
                    ->exists();

            if ($exists) {

                $result = DB::table('activities')
                    ->where('user_id', Auth::user()->id)
                    ->where('id', $request->activity_id)
                    ->update(
                        [
                            'is_edit_requested' => true
                        ]
                    );

                $this->response = [
                    'data' => $result,
                    'status' => true,
                    'error' => null
                ];

                return response()->json($this->response, 422); // 422 Unprocessable Entity - Validation Error
            }else{

                $this->response = [
                    'data' => null,
                    'status' => false,
                    'error' => "not exist"
                ];

                return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }
        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Area overseer
    public function ApprovedRequestEditActivityReport(Request $request){
        try{

            $exists = DB::table('activities')
                    ->where('id', $request->activity_id)
                    ->exists();

            if ($exists) {

                $result = DB::table('activities')
                    ->where('id', $request->activity_id)
                    ->update(
                        [
                            'is_edit_requested' => false,
                            'is_edit_approved' => true
                        ]
                    );

                $this->response = [
                    'data' => $result,
                    'status' => true,
                    'error' => null
                ];

                return response()->json($this->response, 422); // 422 Unprocessable Entity - Validation Error
            }else{

                $this->response = [
                    'data' => null,
                    'status' => false,
                    'error' => "not exist"
                ];

                return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }
        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Area overseer
    public function GetAllRequestEditActivityReport(Request $request){
        try{

            $table_data = DB::select(
            '   SELECT
                    users.id AS user_id,
                    CONCAT(users.firstname, " ", users.middlename, " ", users.lastname) AS name_of_pastors,
                    activities.activity_date,
                    churches.church_name,
                    activities.id AS activity_id
                FROM activities
                JOIN users ON users.id = activities.user_id
                JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                JOIN churches ON churches.id = assigned_church_leaders.church_id
                WHERE assigned_church_leaders.church_id IN (SELECT assigned_church_leaders.church_id FROM assigned_church_leaders WHERE user_id = ?)
                AND is_edit_requested = true
                GROUP BY
                    activities.id',
                [Auth::user()->id]
            );

            $this->response = [
                'data' => $table_data,
                'status' => true,
                'error' => null
            ];

            return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Pastors per church
    public function SubmitEditActivityReport(Request $request){
        try{

            $exists = DB::table('activities')
                    ->where('user_id', Auth::user()->id)
                    ->where('id', $request->activity_id)
                    ->exists();

            if ($exists) {

                $result = DB::table('activities')
                    ->where('user_id', Auth::user()->id)
                    ->where('id', $request->activity_id)
                    ->update(
                        [
                            'adult_attendance_count' => $request->adult_attendance_count,
                            'youth_attendance_count' => $request->youth_attendance_count,
                            'children_attendance_count' => $request->children_attendance_count,

                            'tithes' => $request->tithes,
                            'total_tithes' => $request->total_tithes,
                            'total_offering' => $request->total_offering,
                            'gospel_seed' => $request->gospel_seed,
                            'personal_tithes' => $request->personal_tithes,

                            'new_bible_studies_count' => $request->new_bible_studies_count,
                            'existing_bible_studies_count' => $request->existing_bible_studies_count,

                            'received_jesus_count' => $request->received_jesus_count,

                            'water_baptized_count' => $request->water_baptized_count,
                            'holy_spirit_baptized_count' => $request->holy_spirit_baptized_count,

                            'children_dedication_count' => $request->children_dedication_count,
                            'healed_count' => $request->healed_count,

                            'testimonies_miracles_details' => $request->testimonies_miracles_details,
                            'activity_date' => Carbon::parse($request->activity_date)->format('Y-m-d'),

                            'remarks' => "edited",

                            'is_edit_requested' => false,
                            'is_edit_approved' => false
                        ]
                    );

                $this->response = [
                    'data' => $result,
                    'status' => true,
                    'error' => null
                ];

                return response()->json($this->response, 422); // 422 Unprocessable Entity - Validation Error
            }else{

                $this->response = [
                    'data' => null,
                    'status' => false,
                    'error' => "not exist"
                ];

                return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }
        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Pastors per church
    public function FilterDateRangeReport(Request $request){
        try{

            $query_reponse = [];

            $user_category = DB::table('user_categories')
                            ->where('id', Auth::user()->user_category_id)
                            ->first();

            if($user_category->user_category_title === "area_overseer"){

                $table_data = DB::select(
                    '   SELECT
                            churches.church_name AS churches,
                            CONCAT(users.firstname, " ", users.middlename, " ", users.lastname) AS name_of_pastors,
                            SUM(activities.adult_attendance_count) AS adult,
                            SUM(activities.youth_attendance_count) AS youth,
                            SUM(activities.children_attendance_count) AS children,
                            SUM(activities.adult_attendance_count) + SUM(activities.youth_attendance_count)  + SUM(activities.children_attendance_count) AS total_attendance,
                            SUM(activities.new_bible_studies_count) AS new_bible_study,
                            SUM(activities.existing_bible_studies_count) AS existing_bible_study,
                            SUM(activities.received_jesus_count) AS received_christ,
                            SUM(activities.holy_spirit_baptized_count) AS holy_spirit_baptized,
                            SUM(activities.water_baptized_count) AS water_baptized,
                            SUM(activities.healed_count) AS healed,
                            SUM(activities.children_dedication_count) AS child_dedication,
                            SUM(activities.tithes) AS church_tithes,
                            SUM(activities.total_offering) AS offering,
                            SUM(activities.gospel_seed) AS mission,
                            SUM(activities.personal_tithes) AS personal_tithes

                        FROM activities
                        JOIN users ON users.id = activities.user_id
                        JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                        JOIN churches ON churches.id = assigned_church_leaders.church_id
                        WHERE activity_date BETWEEN ? AND ?
                        AND assigned_church_leaders.church_id IN (SELECT assigned_church_leaders.church_id FROM assigned_church_leaders WHERE user_id = ?)
                        GROUP BY
                            users.id,
                            churches,
                            name_of_pastors,
                            activities.adult_attendance_count,
                            activities.youth_attendance_count,
                            activities.children_attendance_count,
                            activities.new_bible_studies_count,
                            activities.existing_bible_studies_count,
                            activities.received_jesus_count,
                            activities.holy_spirit_baptized_count,
                            activities.water_baptized_count,
                            activities.healed_count,
                            activities.children_dedication_count,
                            activities.tithes,
                            activities.total_offering,
                            activities.gospel_seed,
                            activities.personal_tithes
                    ', [$request->date_from, $request->date_to, Auth::user()->id]);

                    $table_data_total = DB::select(
                        '   SELECT
                                SUM(activities.adult_attendance_count) AS adult,
                                SUM(activities.youth_attendance_count) AS youth,
                                SUM(activities.children_attendance_count) AS children,
                                (SUM(activities.adult_attendance_count) + SUM(activities.youth_attendance_count)  + SUM(activities.children_attendance_count)) AS total_attendance,
                                SUM(activities.new_bible_studies_count) AS new_bible_study,
                                SUM(activities.existing_bible_studies_count) AS existing_bible_study,
                                SUM(activities.received_jesus_count) AS received_christ,
                                SUM(activities.holy_spirit_baptized_count) AS holy_spirit_baptized,
                                SUM(activities.water_baptized_count) AS water_baptized,
                                SUM(activities.healed_count) AS healed,
                                SUM(activities.children_dedication_count) AS child_dedication,
                                SUM(activities.tithes) AS church_tithes,
                                SUM(activities.total_offering) AS offering,
                                SUM(activities.gospel_seed) AS mission,
                                SUM(activities.personal_tithes) AS personal_tithes

                            FROM activities
                            JOIN users ON users.id = activities.user_id
                            JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                            JOIN churches ON churches.id = assigned_church_leaders.church_id
                            WHERE activity_date BETWEEN ? AND ?
                            AND assigned_church_leaders.church_id IN (SELECT assigned_church_leaders.church_id FROM assigned_church_leaders WHERE user_id = ?)
                        ', [$request->date_from, $request->date_to, Auth::user()->id]);

                $query_reponse = array(
                    "table_data" => $table_data,
                    "table_data_total" => $table_data_total
                );

            }else if($user_category->user_category_title === "pastor"){
                // date range from and to
                $query_reponse = DB::select(
                            '   SELECT *
                                FROM activities
                                WHERE user_id = ?
                                AND activity_date between ? AND ?
                                ORDER BY activity_date ASC', [Auth::user()->id, $request->date_from, $request->date_to]);
            }

            $this->response = [
                'data' => $query_reponse,
                'status' => true,
                'error' => null
            ];

            return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Pastors per church
    public function FilterSpecificMonthReport(Request $request){
        try{

            $query_reponse = [];

            $user_category = DB::table('user_categories')
                            ->where('id', Auth::user()->user_category_id)
                            ->first();

            if($user_category->user_category_title === "area_overseer"){

                $table_data = DB::select(
                    '   SELECT
                            users.id AS id,
                            churches.church_name AS churches,
                            CONCAT(users.firstname, " ", users.middlename, " ", users.lastname) AS name_of_pastors,
                            SUM(activities.adult_attendance_count) AS adult,
                            SUM(activities.youth_attendance_count) AS youth,
                            SUM(activities.children_attendance_count) AS children,
                            SUM(activities.adult_attendance_count) + SUM(activities.youth_attendance_count)  + SUM(activities.children_attendance_count) AS total_attendance,
                            SUM(activities.new_bible_studies_count) AS new_bible_study,
                            SUM(activities.existing_bible_studies_count) AS existing_bible_study,
                            SUM(activities.received_jesus_count) AS received_christ,
                            SUM(activities.holy_spirit_baptized_count) AS holy_spirit_baptized,
                            SUM(activities.water_baptized_count) AS water_baptized,
                            SUM(activities.healed_count) AS healed,
                            SUM(activities.children_dedication_count) AS child_dedication,
                            SUM(activities.tithes) AS church_tithes,
                            SUM(activities.total_offering) AS offering,
                            SUM(activities.gospel_seed) AS mission,
                            SUM(activities.personal_tithes) AS personal_tithes

                        FROM activities
                        JOIN users ON users.id = activities.user_id
                        JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                        JOIN churches ON churches.id = assigned_church_leaders.church_id
                        WHERE MONTH(activity_date) = MONTH(?) AND YEAR(activity_date) =  YEAR(?)
                        AND assigned_church_leaders.church_id IN (SELECT assigned_church_leaders.church_id FROM assigned_church_leaders WHERE user_id = ?)
                        GROUP BY
                            activities.user_id
                            -- users.id,
                            -- churches,
                            -- name_of_pastors,
                            -- activities.adult_attendance_count,
                            -- activities.youth_attendance_count,
                            -- activities.children_attendance_count,
                            -- activities.new_bible_studies_count,
                            -- activities.existing_bible_studies_count,
                            -- activities.received_jesus_count,
                            -- activities.holy_spirit_baptized_count,
                            -- activities.water_baptized_count,
                            -- activities.healed_count,
                            -- activities.children_dedication_count,
                            -- activities.tithes,
                            -- activities.total_offering,
                            -- activities.gospel_seed,
                            -- activities.personal_tithes
                    ', [$request->month, $request->year, Auth::user()->id]);

                    $table_data_total = DB::select(
                        '   SELECT
                                SUM(activities.adult_attendance_count) AS adult,
                                SUM(activities.youth_attendance_count) AS youth,
                                SUM(activities.children_attendance_count) AS children,
                                (SUM(activities.adult_attendance_count) + SUM(activities.youth_attendance_count)  + SUM(activities.children_attendance_count)) AS total_attendance,
                                SUM(activities.new_bible_studies_count) AS new_bible_study,
                                SUM(activities.existing_bible_studies_count) AS existing_bible_study,
                                SUM(activities.received_jesus_count) AS received_christ,
                                SUM(activities.holy_spirit_baptized_count) AS holy_spirit_baptized,
                                SUM(activities.water_baptized_count) AS water_baptized,
                                SUM(activities.healed_count) AS healed,
                                SUM(activities.children_dedication_count) AS child_dedication,
                                SUM(activities.tithes) AS church_tithes,
                                SUM(activities.total_offering) AS offering,
                                SUM(activities.gospel_seed) AS mission,
                                SUM(activities.personal_tithes) AS personal_tithes

                            FROM activities
                            JOIN users ON users.id = activities.user_id
                            JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                            JOIN churches ON churches.id = assigned_church_leaders.church_id
                            WHERE MONTH(activity_date) = MONTH(?) AND YEAR(activity_date) =  YEAR(?)
                            AND assigned_church_leaders.church_id IN (SELECT assigned_church_leaders.church_id FROM assigned_church_leaders WHERE user_id = ?)
                        ', [$request->month, $request->year, Auth::user()->id]);

                $query_reponse = array(
                    "table_data" => $table_data,
                    "table_data_total" => $table_data_total
                );

            }else if($user_category->user_category_title === "pastor"){
                // date range from and to
                $table_data = DB::select(
                    '   SELECT *
                        FROM activities
                        WHERE user_id = ?
                        AND MONTH(activity_date) = MONTH(?) AND YEAR(activity_date) =  YEAR(?)
                        ORDER BY activity_date ASC',
                        [Auth::user()->id, $request->month, $request->year]
                );

                $table_data_total = DB::select(
                    'SELECT
                        SUM(adult_attendance_count) AS adult,
                        SUM(youth_attendance_count) AS youth,
                        SUM(children_attendance_count) AS children,
                        SUM(tithes) AS church_tithes,
                        SUM(total_offering) AS offering,
                        SUM(gospel_seed) AS mission,
                        SUM(personal_tithes) AS personal_tithes,
                        (SUM(new_bible_studies_count) + SUM(existing_bible_studies_count)) as total_bible_study,
                        SUM(received_jesus_count) AS received_christ,
                        SUM(water_baptized_count) AS water_baptized,
                        SUM(children_dedication_count) AS child_dedication
                    FROM activities
                    WHERE user_id = ?
                    AND MONTH(activity_date) = MONTH(?) AND YEAR(activity_date) =  YEAR(?)',
                    [Auth::user()->id, $request->month, $request->year]
                );

                $query_reponse = array(
                    "table_data" => $table_data,
                    "table_data_total" => $table_data_total
                );
            }

            $this->response = [
                'data' => $query_reponse,
                'status' => true,
                'error' => null
            ];

            return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Pastors per church
    public function GeneratePDFReport(Request $request){
        try{
            $generated_file = "";

            // save file to server
            $validator = Validator::make($request->all(), [
                'file_report' => [
                    'required',
                    'file',
                    'mimes:pdf'
                ],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();

                $this->response = [
                    'data' => $generated_file,
                    'status' => false,
                    'message' => $errors,
                    'error' => false
                ];

                return response()->json($this->response, 422); // 422 Unprocessable Entity - Validation Error
            }

            $pdf = $request->hasFile('file_report'); // jpeg|png

            if($pdf){
                $file_arr = array(
                    ["file" => $request->file('file_report')],
                );

                foreach ($file_arr as $key => $value) {
                    //origin name
                    $origin_name = $value['file']->getClientOriginalName();
                    //size
                    $size = $value['file']->getSize();
                    //extension
                    $extension = $value['file']->guessClientExtension();
                    //mimetype
                    $mimetype = $value['file']->getClientMimeType();

                    //url
                    $date = new DateTime();
                    $type = explode("/", $mimetype);
                    $url = $value['file']->storeAs(
                        'file',
                        md5_file($value['file']->getRealPath()) . $date->getTimestamp() . "." . $value['file']->guessClientExtension(),
                        'public'
                    );

                    $GeneratedDocument = new GeneratedDocument;
                    $GeneratedDocument->user_id = Auth::user()->id;
                    $GeneratedDocument->file_location = $url;
                    $GeneratedDocument->file_name = $origin_name;
                    $GeneratedDocument->file_type_category = $request->file_type_category;
                    $GeneratedDocument->save();

                    $generated_file = GeneratedDocument::where('id', $GeneratedDocument->id)->first();
                }
            }

            $this->response = [
                'data' => $generated_file,
                'status' => true,
                'error' => null
            ];

            return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Pastors per church
    public function FinalizePDFReport(Request $request){
        try{

            $fileLocation = "";

            $validator = Validator::make($request->all(), [
                'pdf_id' => ['required']
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();

                $this->response = [
                    'data' => "",
                    'status' => false,
                    'message' => $errors,
                    'error' => false
                ];

                return response()->json($this->response, 422); // 422 Unprocessable Entity - Validation Error
            }

            $result = DB::table('generated_documents')
                    ->where('user_id', Auth::user()->id)
                    ->where('id', $request->pdf_id)
                    ->update(
                        [
                            'is_finalized' => true,
                            'date_finalized' => now()
                        ]
                    );

            if($result){

                $overseer_info = DB::table('users')
                ->select('users.*')
                ->join('user_categories', 'user_categories.id', 'users.user_category_id')
                ->where('user_categories.user_category_title', 'area_overseer')
                ->first();

                // $references = [
                //     'nhardbalansag@gmail.com'
                // ];

                $references = [
                    $overseer_info->email,
                    "nhardbalansag@gmail.com"
                ];

                $generated_documents = DB::table('generated_documents')->where('id', $request->pdf_id)->first();
                $fileLocation = env('APP_URL') . "/storage/" . $generated_documents->file_location;
                Mail::to($references)->send(new AreaOverseer($fileLocation));

                $this->response = [
                    'data' => $fileLocation,
                    'status' => true,
                    'error' => null
                ];
            }

            return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Pastors per church
    public function PastorsDashboard(Request $request){
        try{
            $user_category = DB::table('user_categories')
                            ->where('id', Auth::user()->user_category_id)
                            ->first();

            if($user_category->user_category_title === "area_overseer"){
                $total_tithes = DB::select(
                    '   SELECT SUM(total_tithes) as current_month_tithes_total
                        FROM activities
                        JOIN users ON users.id = activities.user_id
                        JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                        JOIN churches ON churches.id = assigned_church_leaders.church_id
                        WHERE Month(activity_date) = MONTH(now())
                        AND year(activity_date) = year(now())
                        AND assigned_church_leaders.church_id
                            IN (
                                SELECT assigned_church_leaders.church_id
                                FROM assigned_church_leaders
                                WHERE user_id = ?
                            )'
                , [Auth::user()->id]);

                $total_offering = DB::select(
                    '   SELECT SUM(total_offering) as current_month_offering_total
                        FROM activities
                        JOIN users ON users.id = activities.user_id
                        JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                        JOIN churches ON churches.id = assigned_church_leaders.church_id
                        WHERE Month(activity_date) = MONTH(now())
                        AND year(activity_date) = year(now())
                        AND assigned_church_leaders.church_id
                            IN (
                                SELECT assigned_church_leaders.church_id
                                FROM assigned_church_leaders
                                WHERE user_id = ?
                            )'
                , [Auth::user()->id]);

                $total_graph_tithes = DB::select(
                    '   SELECT SUM(total_tithes) as data_set, Month(activity_date) as label
                        FROM activities
                        JOIN users ON users.id = activities.user_id
                        JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                        JOIN churches ON churches.id = assigned_church_leaders.church_id
                        WHERE activity_date >= CURDATE() - INTERVAL 3 MONTH
                        AND assigned_church_leaders.church_id
                            IN (
                                SELECT assigned_church_leaders.church_id
                                FROM assigned_church_leaders
                                WHERE user_id = ?
                            )
                        GROUP BY MONTH(activity_date)'
                , [Auth::user()->id]);

                $total_graph_offering = DB::select(
                    '   SELECT SUM(total_offering) as data_set, Month(activity_date) as label
                        FROM activities
                        JOIN users ON users.id = activities.user_id
                        JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                        JOIN churches ON churches.id = assigned_church_leaders.church_id
                        WHERE activity_date >= CURDATE() - INTERVAL 3 MONTH
                        AND assigned_church_leaders.church_id
                            IN (
                                SELECT assigned_church_leaders.church_id
                                FROM assigned_church_leaders
                                WHERE user_id = ?
                            )
                        GROUP BY MONTH(activity_date)'
                , [Auth::user()->id]);

                $total_adult_count = DB::select(
                    '   SELECT SUM(adult_attendance_count) as current_month_adult_total
                        FROM activities
                        JOIN users ON users.id = activities.user_id
                        JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                        JOIN churches ON churches.id = assigned_church_leaders.church_id
                        WHERE Month(activity_date) = MONTH(now())
                        AND year(activity_date) = year(now())
                        AND assigned_church_leaders.church_id
                            IN (
                                SELECT assigned_church_leaders.church_id
                                FROM assigned_church_leaders
                                WHERE user_id = ?
                            )'
                , [Auth::user()->id]);

                $total_youth_count = DB::select(
                    '   SELECT SUM(youth_attendance_count)  as current_month_youth_total
                        FROM activities
                        JOIN users ON users.id = activities.user_id
                        JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                        JOIN churches ON churches.id = assigned_church_leaders.church_id
                        WHERE Month(activity_date) = MONTH(now())
                        AND year(activity_date) = year(now())
                        AND assigned_church_leaders.church_id
                            IN (
                                SELECT assigned_church_leaders.church_id
                                FROM assigned_church_leaders
                                WHERE user_id = ?
                            )'
                , [Auth::user()->id]);

                $total_children_count = DB::select(
                    '   SELECT SUM(children_attendance_count)  as current_month_children_total
                        FROM activities
                        JOIN users ON users.id = activities.user_id
                        JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                        JOIN churches ON churches.id = assigned_church_leaders.church_id
                        WHERE Month(activity_date) = MONTH(now())
                        AND year(activity_date) = year(now())
                        AND assigned_church_leaders.church_id
                            IN (
                                SELECT assigned_church_leaders.church_id
                                FROM assigned_church_leaders
                                WHERE user_id = ?
                            )'
                , [Auth::user()->id]);

                $total_graph_attendee = DB::select(
                    '   SELECT SUM(adult_attendance_count + youth_attendance_count + children_attendance_count) as data_set, Month(activity_date) as label
                        FROM activities
                        JOIN users ON users.id = activities.user_id
                        JOIN assigned_church_leaders ON assigned_church_leaders.user_id = users.id
                        JOIN churches ON churches.id = assigned_church_leaders.church_id
                        WHERE activity_date >= CURDATE() - INTERVAL 3 MONTH
                        AND assigned_church_leaders.church_id
                            IN (
                                SELECT assigned_church_leaders.church_id
                                FROM assigned_church_leaders
                                WHERE user_id = ?
                            )
                        GROUP BY MONTH(activity_date)'
                , [Auth::user()->id]);

                $data = [
                    'tithes' => $total_tithes[0],
                    'offering' => $total_offering[0],
                    'adult' => $total_adult_count[0],
                    'youth' => $total_youth_count[0],
                    'children' => $total_children_count[0],
                    'tithes_graph' => $total_graph_tithes,
                    'offering_graph' => $total_graph_offering,
                    'attendee_graph' => $total_graph_attendee,
                ];

                $this->response = [
                    'data' => $data,
                    'status' => true,
                    'error' => null
                ];

                return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            }else if($user_category->user_category_title === "pastor"){
                // current month total tithes
                $total_tithes = DB::select(
                    '   SELECT SUM(total_tithes) as current_month_tithes_total
                        FROM activities
                        WHERE user_id = ?
                        AND Month(activity_date) = MONTH(now())', [Auth::user()->id]);

                // current month total offering
                $total_offering = DB::select(
                    '   SELECT SUM(total_offering) as current_month_offering_total
                        FROM activities
                        WHERE user_id = ?
                        AND Month(activity_date) = MONTH(now())', [Auth::user()->id]);

                // three previous to current month tithes graph
                $total_graph_tithes = DB::select(
                    '   SELECT SUM(total_tithes) as data_set, Month(activity_date) as label
                        FROM activities
                        WHERE user_id = ?
                        AND activity_date >= CURDATE() - INTERVAL 3 MONTH
                        GROUP BY MONTH(activity_date)', [Auth::user()->id]);

                // three previous to current month offering graph
                $total_graph_offering = DB::select(
                    '   SELECT SUM(total_offering) as data_set, Month(activity_date) as label
                        FROM activities
                        WHERE user_id = ?
                        AND activity_date >= CURDATE() - INTERVAL 3 MONTH
                        GROUP BY MONTH(activity_date)', [Auth::user()->id]);

                // current month total adult attendee
                $total_adult_count = DB::select(
                    '   SELECT SUM(adult_attendance_count) as current_month_adult_total
                        FROM activities
                        WHERE user_id = ?
                        AND Month(activity_date) = MONTH(now());', [Auth::user()->id]);

                // current month total youth attendee
                $total_youth_count = DB::select(
                    '   SELECT SUM(youth_attendance_count)  as current_month_youth_total
                        FROM activities
                        WHERE user_id = ?
                        AND Month(activity_date) = MONTH(now());', [Auth::user()->id]);

                // current month total children attendee
                $total_children_count = DB::select(
                    '   SELECT SUM(children_attendance_count)  as current_month_children_total
                        FROM activities
                        WHERE user_id = ?
                        AND Month(activity_date) = MONTH(now());', [Auth::user()->id]);

                // three previous to current month total attendee graph
                $total_graph_attendee = DB::select(
                    '   SELECT SUM(adult_attendance_count + youth_attendance_count + children_attendance_count) as data_set, Month(activity_date) as label
                        FROM activities
                        WHERE user_id = ?
                        AND activity_date >= CURDATE() - INTERVAL 3 MONTH
                        GROUP BY MONTH(activity_date)', [Auth::user()->id]);

                $data = [
                    'tithes' => $total_tithes[0],
                    'offering' => $total_offering[0],
                    'adult' => $total_adult_count[0],
                    'youth' => $total_youth_count[0],
                    'children' => $total_children_count[0],
                    'tithes_graph' => $total_graph_tithes,
                    'offering_graph' => $total_graph_offering,
                    'attendee_graph' => $total_graph_attendee,
                ];

                $this->response = [
                    'data' => $data,
                    'status' => true,
                    'error' => null
                ];

                return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }

        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Pastors per church
    public function GetMyPDFReports(Request $request){
        try{

            $files = DB::select(
                '   SELECT *
                    FROM generated_documents
                    WHERE user_id = ?
                    AND is_deleted = false
                    ORDER BY created_at DESC', [Auth::user()->id]);

            // $files = DB::table('generated_documents')->where('user_id', Auth::user()->id)->paginate(5);

            $this->response = [
                'data' => $files,
                'status' => true,
                'error' => null
            ];

            return response()->json($this->response, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        } catch (Exception $exception) {
            $this->response = [
                'data' => null,
                'status' => false,
                'error' => $exception->getMessage()
            ];

            return response()->json($this->response, 500); // 500 Internal Server Error
        }
    }

    // Area overseer
    public function RecognizeGeneratedPDFReport(Request $request){}


}
