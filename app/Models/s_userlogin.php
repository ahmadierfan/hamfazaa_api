<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class s_userlogin extends Model
{
    protected $table = "s_userlogins";
    protected $primaryKey = 'pk_userlogin';
    protected $guarded = [];
}
