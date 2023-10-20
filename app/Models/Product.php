<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{

    public function getProducts()
    {
        $products = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name')
            ->orderBy('products.created_at', 'desc')
            ->paginate(5); 
    
        return $products; 
    }

    public function uploadImage(\Illuminate\Http\UploadedFile $image)
    {
        $path = 'images/products'; // 保存先ディレクトリを指定
        $filename = uniqid() . '_' . $image->getClientOriginalName();
        $image->storeAs($path, $filename, 'public');
        return $path . '/' . $filename;
    }
    

    public function relatedData()
    {
        return $this->belongsTo(RelatedData::class, 'related_data_id', 'id');
    }

    public function getRelatedData()
    {
        return DB::table('products')
            ->select('product_name as relatedData', 'id')
            ->where('id', $this->id)
            ->first();
    }

    public function deleteProduct()
    {
        DB::table('products')->where('id', $this->id)->delete();
    }

    public function getSearchResults($search, $manufacturer)
    {
        $query = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name')
            ->orderBy('products.created_at', 'desc');

        if ($search) {
            $query->where('products.product_name', 'like', '%' . $search . '%');
        }

        if ($manufacturer) {
            $query->where('products.company_id', $manufacturer);
        }

        return $query->paginate(10);
    }

}


