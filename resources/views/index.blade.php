@extends('app')

@section('content')
<div class="row" style="margin-top: 15px;">
  <div class="col-lg-12">
    <div class="text-left">
      <h2 style="font-size:1.5rem;">商品一覧画面</h2>
    </div>
  </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="col-12 mb-2 mt-2">
    <form action="{{ route('product.search') }}" method="GET">
        <div class="input-group" style="width: 50%;">
            <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="検索キーワード">
            <select name="manufacturer" class="form-select">
                <option value="">メーカー名</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">検索</button>
            </div>
            <div style="width: 10px;"></div> <!-- スペースを追加 -->
            <a class="btn btn-primary rounded-pill" href="{{ route('product.create') }}">新規登録</a>
        </div>
    </form>
</div>



<table class="table table-bordered">
<tr>
      <th>No</th>
      <th>商品画像</th>
      <th>商品名</th>
      <th>価格</th>
      <th>在庫数</th>
      <th>メーカー名</th>
      <th></th>
      <th></th>
   </tr>
          @foreach($products as $product) 
          <tr>
                <td style="text-align:right">{{ $product->id }}</td>
                <td>
                <img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->product_name }}" width="45">
                </td>
                <td>{{ $product->product_name }}</td>
                <td style="text-align:right">{{ $product->price }}円</td>
                <td style="text-align:right">{{ $product->stock }}</td>
                <td>{{ $product->company_name }}</td>
                <td style="text-align:center">
                      <a class="btn btn-primary" href="{{ route('product.show',$product->id) }}">詳細</a>
                      <td style="text-align:center">
                <form action="{{ route('product.destroy',$product->id) }}" method="POST">
               @csrf
               @method('DELETE')
               <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか？");'>削除</button>
               </form>
               </td>
          </tr>
          @endforeach
</table>

{!! $products->links('pagination::bootstrap-5') !!}

@endsection


