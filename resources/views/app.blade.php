<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: "Helvetica Neue", Arial, "Hiragino Sans", Meiryo, sans-serif;
            margin-top: 23px; /* 画面最上部との余白を追加 */
        }
    </style>
    <!-- jQueryの読み込み -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

</head>
<body>
    <div class="container">
        <h1 style="font-size:2.0rem;">自動販売機売上管理システム</h1>
        @yield('content')
    </div>
    <div>@yield('scripts')</div>

    <!-- BootstrapのJavaScriptファイルを読み込む -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
