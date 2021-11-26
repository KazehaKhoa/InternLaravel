<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Customer extends Model
{
    use HasFactory;

    protected $guarded =[];

    public static function getCustomers() {
        $data = DB::table('customers')->select('customer_name', 'email', 'tel_num', 'address')->get()->toArray();
        return $data;
    }
}
