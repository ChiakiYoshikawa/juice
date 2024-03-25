<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function getAllCompanies()
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
