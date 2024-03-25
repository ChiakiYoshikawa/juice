@extends('app')

@section('content')
 <div class="row">
  <div class="col-lg-12 margin-tb">
   <div class="pull-left">
    <h2 style="font-size:1.5rem;">商品新規登録画面</h2>
   </div>
   <div class="pull-right">
  <a class="btn btn-success" href="{{ url('/product') }}">戻る</a>
  </div>
 </div>
</div>

<div style="text-align:right;">
<form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
 @csrf

<div class="row">
  <div class="col-12 mb-2 mt-2">
   <div class="form-group">
   <input type="text" name="product_name" class="form-control" placeholder="商品名">
   @error('product_name')
     <span style="color:red;">名前を50文字以内で入力してください</span>
     @enderror
  </div>
 </div>
  <div class="col-12 mb-2 mt-2">
   <div class=“form-group”>
   <input type="text" name="price" class="form-control" placeholder="価格">
   @error('price')
     <span style="color:red;">価格を数字で入力してください</span>
     @enderror
  </div>
 </div>
  <div class="col-12 mb-2 mt-2">
   <div class="form-group">
   <input type="text" name="stock" class="form-control" placeholder="在庫数">
   @error('stock')
     <span style="color:red;">在庫数を数字で入力してください</span>
     @enderror
  </div>
 </div>
 <div class="col-12 mb-2 mt-2">
   <div class=“form-group”>
   <input type="text" name="comment" class="form-control" placeholder="コメント">
   </div>
 </div>
 <div class="col-12 mb-2 mt-2">
 <div class="form-group">
  <select name="company_id" class="form-select">
   <option>分類を選択してください</option>
   @foreach($companies as $company)
    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
   @endforeach
  </select>
  @error('company_id')
    <span style="color:red;">分類を選択してください</span>
    @enderror
 </div>
</div>
<div class="col-12 mb-2 mt-2">
 <div class="form-group">
  <input type="file" name="image" class="form-control-file">
  @error('image')
    <span style="color: red;">画像を選択してください</span>
    @enderror
 </div>
</div>
<div class="col-12 mb-2 mt-2">
 <button type="submit" class="btn btn-primary w-100">登録</button>
 </div>
</div>
</form>
</div>

@endsection