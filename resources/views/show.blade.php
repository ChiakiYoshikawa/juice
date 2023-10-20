@extends('app')

@section('content')
 <div class="row">
  <div class="col-lg-12 margin-tb">
   <div class="pull-left">
    <h2 style="font-size:1.5rem;">商品情報詳細画面</h2>
   </div>
 </div>
</div>

<div class="row">
  <div class="col-12 mb-2 mt-2">
  <img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->product_name }}" width="200">
  </div>
</div>

<div class="row">
  <div class="col-12 mb-2 mt-2">
  <p>{{ $product->product_name }}</p>
    <p>価格: {{ $product->price }}円</p>
    <p>在庫数: {{ $product->stock }}</p>
    <p>メーカー名: {{ $product->company_name }}</p>
    <p>コメント: {{ $product->comment }}</p>
    </div>
</div>

<div class="d-flex">
   <div>
   <a class="btn btn-success" href="{{ route('product.edit', ['product' => $product->id]) }}">編集</a>
  </div>
  <div class="mr-2">
    <a class="btn btn-success" href="{{ url('/product') }}">戻る</a>
  </div>

@endsection