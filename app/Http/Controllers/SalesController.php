<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // 必要なデータを取得
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
    
        // 商品を検索
        $product = Product::find($productId);
    
        // 商品が存在しない場合
        if (!$product) {
            return response()->json(['message' => '商品が存在しません'], 404);
        }
    
        // 在庫が不足している場合
        if ($product->stock < $quantity) {
            return response()->json(['message' => '商品が在庫不足です'], 400);
        }
    
        // 在庫を減らす処理
        try {
            DB::transaction(function () use ($product, $quantity) {
                $product->decrement('stock', $quantity);
    
                // 購入履歴を記録
                Sale::create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => '購入処理中にエラーが発生しました'], 500);
        }
    
        // 成功時のレスポンス
        return response()->json(['message' => '購入が完了しました'], 200);
    }
    

}