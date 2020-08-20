<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class ActivityLogController extends Controller
{
          //Function to check user is authenticated

          public function __construct() {
            $this->middleware( 'auth:web' );
        }
        
        //Function to get activity logs and display them
        public function index() {
    
            $activity_logs = DB::table('log_activities')
            ->select('log_activities.*', 'log_activities.id as activity_id', 'users.*')
            ->join('users', 'log_activities.user_id', '=', 'users.id')
            ->orderBy('log_activities.created_at', 'DESC')
            ->get();
    
            $data = array(
              'user' => Auth::user(),
              'activity_logs'=> $activity_logs
    
            );
    
            return view('activitylog.index')->with($data);
        }
    
}
