<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\V1\Activity\Activity;

class ReportController extends Controller
{

    public $response = [];

    // Pastors per church
    public function CreateActivityReport(Request $request){
        try{

            $result = Activity::create([
                'user_id' => Auth::user()->id,
                'activity_category_id' => $request->activity_category_id,

                'adult_attendance_count' => $request->adult_attendance_count,
                'youth_attendance_count' => $request->youth_attendance_count,
                'children_attendance_count' => $request->children_attendance_count,

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


            $this->response = [
                'data' => null,
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
    public function PastorsDashboard(Request $request){
        try{
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
                '   SELECT SUM(total_tithes) as tithes, Month(activity_date) as month
                    FROM activities
                    WHERE user_id = ?
                    AND activity_date >= CURDATE() - INTERVAL 3 MONTH
                    GROUP BY MONTH(activity_date)', [Auth::user()->id]);

            // three previous to current month offering graph
            $total_graph_offering = DB::select(
                '   SELECT SUM(total_offering) as tithes, Month(activity_date) as month
                    FROM activities
                    WHERE user_id = ?
                    AND activity_date >= CURDATE() - INTERVAL 3 MONTH
                    GROUP BY MONTH(activity_date)', [Auth::user()->id]);

            // current month total adult attendee
            $total_adult_count = DB::select(
                '   SELECT SUM(adult_attendance_count)
                    FROM activities
                    WHERE user_id = ?
                    AND Month(activity_date) = MONTH(now());', [Auth::user()->id]);

            // current month total youth attendee
            $total_youth_count = DB::select(
                '   SELECT SUM(youth_attendance_count)
                    FROM activities
                    WHERE user_id = ?
                    AND Month(activity_date) = MONTH(now());', [Auth::user()->id]);
            // current month total children attendee
            $total_children_count = DB::select(
                '   SELECT SUM(children_attendance_count)
                    FROM activities
                    WHERE user_id = ?
                    AND Month(activity_date) = MONTH(now());', [Auth::user()->id]);
            // three previous to current month total attendee graph
            $total_graph_attendee = DB::select(
                '   SELECT SUM(adult_attendance_count + youth_attendance_count + children_attendance_count) as total_attendee, Month(activity_date) as month
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
