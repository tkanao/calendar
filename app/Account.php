<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = array('id');
    
    public static $rules = array(
        'title' => 'required',
        'memo' => 'required',
        'date' => 'required'
    );
}
