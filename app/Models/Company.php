<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    public static function getAllCompanies()
    {
        return DB::table('companies')->get();
    }

    public function getManufacturers()
    {
        return DB::table('companies')->pluck('company_name', 'id');
    }

    public function getCompanies()
    {
        return DB::table('companies')->get();
    }
}

