<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_order extends Model
{
    protected $table = 'm_orders';
    protected $primaryKey = 'pk_order';
    protected $guarded = [];
}
