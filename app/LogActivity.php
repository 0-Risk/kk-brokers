<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $fillable = [
        'subject','details', 'url', 'method', 'ip',  'user_id'
    ];

}
