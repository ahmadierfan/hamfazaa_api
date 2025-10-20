<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_verificationcode extends Model
{

    protected $table = 'm_verificationcodes';
    protected $primaryKey = 'pk_verificationcode';
    protected $guarded = [];
}
