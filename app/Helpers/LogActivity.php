<?php


namespace App\Helpers;
use Request;
use App\LogActivity as ActivityLog;


class LogActivity
{


    public static function addToLog($subject, $details, $user_id)
    {
        $log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['details'] = $details;
    	$log['user_id'] = $user_id;
    	ActivityLog::create($log);

    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}
