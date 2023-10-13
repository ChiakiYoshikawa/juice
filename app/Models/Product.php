<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'product_id', 'id');
    }
}

