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
        $companies = Company::all(); // ここで $companies を取得
        $products = Product::with('company')->latest()->paginate(5);
        return view('index', compact('products', 'companies')); // $companies も compact に追加
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('create')
        ->with('companies',$companies);

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
            'product_name'=>'required|max:20',
            'price'=>'required|integer',
            'stock'=>'required|integer',
            'company_id'=>'required|max:140',
            ]);

            $image = $request->file('image');
            $path = 'images/products';// 保存先ディレクトリを指定
            $filename = null;
            if ($image) {
                // ファイル名を一意に生成
                $filename = uniqid() . '_' . $image->getClientOriginalName();
                // ファイルを指定ディレクトリに保存
                $image->storeAs($path, $filename, 'public');
            }

            $product = new Product;
            $product->product_name = $request->input(["product_name"]);
            $product->price = $request->input(["price"]);
            $product->stock = $request->input(["stock"]);
            $product->company_id = $request->input(["company_id"]);
            $product->comment = $request->input(["comment"]);
            $product->img_path = $path . '/' . $filename; // 画像のパスを保存
            $product->save();
    
            return redirect()->route('product.index')
            ->with('success','商品を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
            // 商品名と商品IDに関連づくデータを取得
    $relatedData = $product->productName;

    // $relatedData を使用してデータを利用

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
        $companies = Company::all();
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
            'product_name'=>'required|max:20',
            'price'=>'required|integer',
            'stock'=>'required|integer',
            'company_id'=>'required|max:140',
            ]);

            $image = $request->file('image');
            $path = 'images/products';// 保存先ディレクトリを指定
            $filename = null;
            if ($image) {
                // ファイル名を一意に生成
                $filename = uniqid() . '_' . $image->getClientOriginalName();
                // ファイルを指定ディレクトリに保存
                $image->storeAs($path, $filename, 'public');
            }
            
            $product->product_name = $request->input(["product_name"]);
            $product->price = $request->input(["price"]);
            $product->stock = $request->input(["stock"]);
            $product->company_id = $request->input(["company_id"]);
            $product->comment = $request->input(["comment"]);
            $product->img_path = $path . '/' . $filename; // 画像のパスを保存
            $product->save();
            
            return redirect()->route('product.index')
            ->with('success',$product->product_name . 'を変更しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')
        ->with('success',$product->product_name . 'を削除しました');
    }
    
    public function search(Request $request)
    {
        $search = $request->input('search');
        $manufacturer = $request->input('manufacturer');
    
        $query = Product::query();
    
        if ($search) {
            $query->where('product_name', 'like', '%' . $search . '%');
        }
    
        if ($manufacturer) {
            $query->where('company_id', $manufacturer);
        }
    
        $products = $query->paginate(10);
    
        // メーカー情報を取得
        $manufacturers = Company::pluck('company_name', 'id');
        $companies = Company::all();
    
        return view('index', compact('products', 'manufacturers', 'companies'));
    }
    

}
