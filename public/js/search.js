$(document).ready(function() {
    $('#search-form').submit(function(event) {
        event.preventDefault(); // デフォルトのフォーム送信を無効化

        // 検索クエリやその他のデータを取得
        var searchQuery = $('#search').val();
        var manufacturer = $('#manufacturer').val();

        // Ajaxリクエストを送信
        var searchRoute = $('#app').data('search-route');
        $.ajax({
            type: 'GET',
            url: searchRoute,
            data: {
                search: searchQuery,
                manufacturer: manufacturer
            },
            success: function(response) {
                // レスポンスデータを処理するロジックをここに追加
                // 例：成功時に商品リストを更新するなどの処理
            },
            error: function(xhr, status, error) {
                // エラーハンドリングをここに追加
                console.error('Ajaxリクエストエラー:', status, error);
            }
        });
    });
});

