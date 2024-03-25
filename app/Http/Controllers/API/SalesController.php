<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // リクエストから商品IDを取得
        $productId = $request->input('product_id');

        // 商品を取得
        $product = Product::find($productId);

        // 商品が存在しない場合や在庫がない場合はエラーを返す
        if (!$product || $product->stock < 1) {
            return response()->json(['error' => '指定された商品は存在しないか在庫がありません'], 404);
        }

        // 購入処理の実行
        try {
            DB::transaction(function () use ($product) {
                // salesテーブルに新しいレコードを挿入
                Sale::create([
                    'product_id' => $product->id,
                ]);

                // productsテーブルの在庫数を減算
                $product->decrement('stock', 1);
            });
        } catch (\Exception $e) {
            // エラーが発生した場合はエラーメッセージを返す
            return response()->json(['error' => '購入処理中にエラーが発生しました'], 500);
        }

        // 成功時のレスポンスを返す
        return response()->json(['message' => '商品の購入が完了しました'], 200);
    }
}
