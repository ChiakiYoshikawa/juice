$(document).ready(function() {
    // 初回データを読み込む関数
    function loadInitialData() {
        $.ajax({
            type: 'GET',
            url: '/load-initial-data', // サーバーエンドポイントを設定
            success: function(response) {
                // データを表示
                displayData(response);
            }
        });
    }

    // 新しいデータを読み込む関数
    function loadMoreData() {
        $.ajax({
            type: 'GET',
            url: '/load-more-data', // サーバーエンドポイントを設定
            success: function(response) {
                console.log(response);
                displayData(response);
            }
        });
    }

    // データを表示する関数
    function displayData(data) {
        // データを表示するロジックを実装
        // 例: 新しい要素を生成または既存の要素に追加
    }

    loadInitialData();

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            loadMoreData();
        }
    });
});
