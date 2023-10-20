<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
        public function index()
        {
            $products = (new Product())->getProducts();
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $relatedData = $product->getRelatedData();
        return view('show', compact('product', 'relatedData'));
        
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
        $request->validate([
            'product_name' => 'required|max:20',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'company_id' => 'required|max:140',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
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
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->deleteProduct();
    
        return redirect()->route('product.index')
            ->with('success', $product->product_name . 'を削除しました');
    }
    
    public function search(Request $request)
    {
        $search = $request->input('search');
        $manufacturer = $request->input('manufacturer');
    
        $productModel = new Product();
        $products = $productModel->getSearchResults($search, $manufacturer);
    
        $companyModel = new Company();
        $manufacturers = $companyModel->getManufacturers();
        $companies = $companyModel->getCompanies();
    
        return view('index', compact('products', 'manufacturers', 'companies'));
    }
    

}