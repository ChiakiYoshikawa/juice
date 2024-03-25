<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use Sortable;

    protected $fillable = ['product_name', 'price', 'stock'];
    public $sortable = ['id', 'product_name', 'price', 'stock'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeGetProductsQuery($query)
    {
        return $query->leftJoin('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name')
            ->orderBy('products.created_at', 'desc');
    }

    public function uploadImage(\Illuminate\Http\UploadedFile $image)
    {
        $path = 'images/products';
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

    public function getSearchResults($search, $manufacturer, $minPrice, $maxPrice, $minStock, $maxStock)
    {
        $query = $this->getProductsQuery(); // クエリスコープを呼び出す

        if ($search) {
            $query->where('products.product_name', 'like', '%' . $search . '%');
        }

        if ($manufacturer) {
            $query->where('products.company_id', $manufacturer);
        }

        if ($minPrice) {
            $query->where('products.price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('products.price', '<=', $maxPrice);
        }

        if ($minStock) {
            $query->where('products.stock', '>=', $minStock);
        }

        if ($maxStock) {
            $query->where('products.stock', '<=', $maxStock);
        }

        return $query->paginate(5);
    }
}
