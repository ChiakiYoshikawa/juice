<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
 
public function index(Request $request)
{
    $query = Product::sortable()->getProductsQuery();

    // 検索条件がある場合は、クエリを変更する
    if ($request->filled('search')) {
        $query->where('product_name', 'like', '%' . $request->input('search') . '%');
    }

    if ($request->filled('manufacturer')) {
        $query->where('company_id', $request->input('manufacturer'));
    }

    if ($request->filled('minPrice')) {
        $query->where('price', '>=', $request->input('minPrice'));
    }

    if ($request->filled('maxPrice')) {
        $query->where('price', '<=', $request->input('maxPrice'));
    }

    if ($request->filled('minStock')) {
        $query->where('stock', '>=', $request->input('minStock'));
    }

    if ($request->filled('maxStock')) {
        $query->where('stock', '<=', $request->input('maxStock'));
    }

    $products = $query->paginate(5);
    $companies = Company::getAllCompanies();

    return view('index', compact('products', 'companies'));
}


     public function create()
     {
         $companies = Company::getAllCompanies();
         return view('create', compact('companies'));
     }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
         try {
             return DB::transaction(function () use ($request) {
                 $request->validate([
                     'product_name' => 'required|max:20',
                     'price' => 'required|integer',
                     'stock' => 'required|integer',
                     'company_id' => 'required|max:140',
                 ]);
             
                 $image = $request->file('image');
                 $product = new Product;
                 $product->product_name = $request->input('product_name');
                 $product->price = $request->input('price');
                 $product->stock = $request->input('stock');
                 $product->company_id = $request->input('company_id');
                 $product->comment = $request->input('comment');
                 
                 // ファイルをアップロードし、パスを取得
                 if ($image) {
                     $imagePath = $product->uploadImage($image);
                     $product->img_path = $imagePath;
                 }
                 
                 $product->save();
             
                 return redirect()->route('product.index')
                     ->with('success', '商品を登録しました');
             });
         } catch (QueryException $e) {
             // エラーが発生した場合の処理を追加
             \Log::error('Database error: ' . $e->getMessage());
             return redirect()->route('product.index')
                 ->with('error', 'データベースエラーが発生しました。');
         }
     }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product = (new Product())->getProductsQuery()
            ->where('products.id', $product->id)
            ->first();
    
        return view('show', compact('product'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $companies = Company::getAllCompanies();
        return view('edit',compact('product'))
        ->with('companies', $companies);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {
            return DB::transaction(function () use ($request, $product) {
                $request->validate([
                    'product_name' => 'required|max:20',
                    'price' => 'required|integer',
                    'stock' => 'required|integer',
                    'company_id' => 'required|max:140',
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
    
                // 既存の商品情報を更新
                $product->product_name = $request->input('product_name');
                $product->price = $request->input('price');
                $product->stock = $request->input('stock');
                $product->company_id = $request->input('company_id');
                $product->comment = $request->input('comment');
            
                // ファイルをアップロードし、パスを取得して更新
                if ($request->hasFile('image')) {
                    $imagePath = $product->uploadImage($request->file('image'));
                    $product->img_path = $imagePath;
                }
            
                $product->save();
            
                return redirect()->route('product.index')
                    ->with('success', $product->product_name . 'を変更しました');
            });
        } catch (QueryException $e) {
            // エラーが発生した場合の処理を追加
            \Log::error('Database error: ' . $e->getMessage());
            return redirect()->route('product.index')
                ->with('error', 'データベースエラーが発生しました。');
        }
    }  

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $productId = $request->id; // リクエストからIDを取得
        
        $product = Product::findOrFail($productId); // IDに対応する商品を取得
        
        logger($product);
        
        $product->delete(); // 商品を削除
        
        return response()->json(['message' => $product->product_name . 'を削除しました']);
    }    
    
    
    public function search(Request $request)
    {
        // 検索条件をリクエストから取得
        $search = $request->input('search');
        $manufacturer = $request->input('manufacturer');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $minStock = $request->input('min_stock');
        $maxStock = $request->input('max_stock');
    
        // クエリの生成
        $query = Product::sortable()->getProductsQuery();
    
        // 検索条件に応じてクエリを絞り込む
        if ($search) {
            $query->where('product_name', 'like', '%' . $search . '%');
        }
    
        if ($manufacturer) {
            $query->where('company_id', $manufacturer);
        }
    
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
    
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
    
        if ($minStock) {
            $query->where('stock', '>=', $minStock);
        }
    
        if ($maxStock) {
            $query->where('stock', '<=', $maxStock);
        }
    
        // ページネーションを適用して検索結果を取得
        $products = $query->paginate(5);
        $companies = Company::all();
    
        if ($request->ajax()) {
            return view('index', compact('products', 'companies'))->render(); // Ajaxリクエストの場合、部分ビューを返す
        }
    
        return view('index', compact('products', 'companies')); // 通常のリクエストの場合は、indexビューを返す
    }
    
}