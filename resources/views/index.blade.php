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

<div class="search-wrapper col-sm-4">
    <div class="user-search-form">
        <input type="text" name="search" id="search" class="form-control shadow" value="{{ request('search') }}" placeholder="検索キーワード">
        <input type="number" name="min_price" id="min_price" class="form-control" value="{{ request('min_price') }}" placeholder="最小価格">
        <input type="number" name="max_price" id="max_price" class="form-control" value="{{ request('max_price') }}" placeholder="最大価格">
        <input type="number" name="min_stock" id="min_stock" class="form-control" value="{{ request('min_stock') }}" placeholder="最小在庫数">
        <input type="number" name="max_stock" id="max_stock" class="form-control" value="{{ request('max_stock') }}" placeholder="最大在庫数">
        <select name="manufacturer" id="manufacturer" class="form-select">
            <option value="">メーカー名</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
        </select>
        <button type="button" class="btn search-icon" id="search_button">検索<i class="fa fa-search" aria-hidden="true"></i></button>
        <a class="btn btn-warning rounded-pill" href="{{ route('product.create') }}">新規登録</a>
    </div>
</div>



<div id="product-table">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" style="width: 65px;">@sortablelink('id', 'ID')</th>
                <th style="width: 100px;">商品画像</th>
                <th scope="col" style="width: 100px;">@sortablelink('product_name', '商品名')</th>
                <th scope="col" style="width: 100px;">@sortablelink('price', '価格')</th>
                <th scope="col" style="width: 100px;">@sortablelink('stock', '在庫数')</th>
                <th style="width: 150px;">メーカー名</th>
                <th style="width: 100px;"></th>
                <th style="width: 100px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td style="text-align:right">{{ $product->id }}</td>
                <td>
                    <img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->product_name }}" width="45">
                </td>
                <td>{{ $product->product_name }}</td>
                <td style="text-align:right">{{ $product->price }}円</td>
                <td style="text-align:right">{{ $product->stock }}</td>
                <td>{{ $product->company_name ?? '' }}</td>
                <td style="text-align:center">
                    <a class="btn btn-info" href="{{ route('product.show',$product->id) }}">詳細</a>
                </td>
                <td style="text-align:center">
                    <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-product-id="{{ $product->id }}">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="pagination-links">
        {!! $products->appends(request()->query())->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // 検索ボタンがクリックされたときの処理
    $('#search_button').on('click', function() {
        // 検索フォームのデータを取得
        var formData = {
            search: $('#search').val(),
            min_price: $('#min_price').val(),
            max_price: $('#max_price').val(),
            min_stock: $('#min_stock').val(),
            max_stock: $('#max_stock').val(),
            manufacturer: $('#manufacturer').val()
        };
        
        // Ajaxリクエストを送信して検索を実行
        $.ajax({
            type: 'GET',
            url: '/products/search',
            data: formData,
            dataType: 'html',
            success: function(response) {
                // 取得したHTMLをテーブル内のtbodyに挿入する
                $('#product-table tbody').html($(response).find('tbody').html());
            },
            error: function(xhr, status, error) {
                console.error('検索中にエラーが発生しました:', error);
            }
        });
    });
});

</script>

<script>
    $(document).ready(function() {
        // 削除ボタンがクリックされたときの処理
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();

            // 削除する商品のIDを取得
            var productId = $(this).data('product-id');

            // 確認ダイアログを表示して削除の可否をユーザーに確認
            if (confirm('本当に削除しますか？')) {
                // Ajaxリクエストを送信して商品を削除
                $.ajax({
                    type: 'POST', // POSTメソッドに変更
                    url: '/products/' + productId, // リクエスト先のURL
                    data: {
                        _method: 'DELETE', // LaravelでDELETEリクエストを処理するための_methodパラメータ
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRFトークン
                    },
                    dataType: 'json', // 返却されるデータの形式をJSONに指定
                    success: function(response) {
                        console.log('非同期通信が成功しました。レスポンス:', response);
                        // 成功した場合はメッセージを表示し、画面を更新
                        alert('商品を削除しました。');
                        // ページをリロードしてページネーションを更新
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('非同期通信中にエラーが発生しました:', error); // エラー時のコンソールログを追加
                        // エラーが発生した場合はエラーメッセージを表示
                        alert('商品の削除中にエラーが発生しました。もう一度試してください。');
                    }
                });
            }
        });
    });
</script>

@endsection
