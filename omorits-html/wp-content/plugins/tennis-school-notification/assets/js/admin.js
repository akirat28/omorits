jQuery(document).ready(function($) {
    // 日本語カレンダーの設定
    $.datepicker.regional['ja'] = {
        closeText: '閉じる',
        prevText: '前月',
        nextText: '次月',
        currentText: '今日',
        monthNames: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
        monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
        dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
        dayNamesShort: ['日','月','火','水','木','金','土'],
        dayNamesMin: ['日','月','火','水','木','金','土'],
        weekHeader: '週',
        dateFormat: 'yy-mm-dd',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: '年'
    };
    $.datepicker.setDefaults($.datepicker.regional['ja']);

    // Datepickerの初期化
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: 0, // 今日以降の日付のみ選択可能
        onSelect: function(dateText) {
            updatePreview();
        }
    });

    // サンプルメッセージ選択時の処理
    $('#sample_message_selector').on('change', function() {
        var selectedMessage = $(this).val();
        if (selectedMessage) {
            // 現在の日付を取得して置換
            var date = $('#notification_date').val();
            if (date) {
                var dateObj = new Date(date);
                var weekdays = ['日', '月', '火', '水', '木', '金', '土'];
                var formattedDate = (dateObj.getMonth() + 1) + '月' + dateObj.getDate() + '日（' + weekdays[dateObj.getDay()] + '）';
                selectedMessage = selectedMessage.replace(/○月○日（曜日）/, formattedDate);
            }

            $('#message').val(selectedMessage);
            updatePreview();
        }
    });

    // メッセージ入力時の処理
    $('#message').on('input', function() {
        updatePreview();
    });

    // 色選択時の処理
    $('input[name="color"]').on('change', function() {
        updatePreview();
    });

    // プレビュー更新関数
    function updatePreview() {
        var date = $('#notification_date').val();
        var message = $('#message').val();
        var color = $('input[name="color"]:checked').val();

        if (!date || !message || !color) {
            $('#tsn-preview-area').html('<div class="tsn-notification-preview">プレビューはここに表示されます</div>');
            return;
        }

        // 日付フォーマット
        var dateObj = new Date(date);
        var weekdays = ['日', '月', '火', '水', '木', '金', '土'];
        var formattedDate = (dateObj.getMonth() + 1) + '月' + dateObj.getDate() + '日（' + weekdays[dateObj.getDay()] + '）';

        // 現在時刻を更新日時として表示
        var now = new Date();
        var updatedTime = (now.getMonth() + 1) + '/' + now.getDate() + ' ' +
                         ('0' + now.getHours()).slice(-2) + ':' +
                         ('0' + now.getMinutes()).slice(-2) + ' 更新';

        // アイコンの選択
        var icon = '';
        switch(color) {
            case 'green':
                icon = '✓'; // チェックマーク
                break;
            case 'yellow':
                icon = '⚠'; // 警告マーク
                break;
            case 'red':
                icon = '✕'; // バツマーク
                break;
        }

        // プレビューHTML生成（フロントエンドと同じ構造）
        var previewHtml = '<div class="tsn-notification tsn-' + color + ' tsn-today">' +
                         '<div class="tsn-notification-header">' +
                         '<span class="tsn-icon">' + icon + '</span>' +
                         '<span class="tsn-label">' + formattedDate + 'のテニススクール開催連絡</span>' +
                         '<span class="tsn-date">' + updatedTime + '</span>' +
                         '</div>' +
                         '<div class="tsn-notification-content">' +
                         '<p>' + escapeHtml(message) + '</p>' +
                         '</div>' +
                         '</div>';

        $('#tsn-preview-area').html(previewHtml);
    }

    // HTMLエスケープ関数
    function escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // 初回プレビュー更新
    updatePreview();

    // 削除確認（AJAX版）
    $('.delete-notification-ajax').on('click', function(e) {
        e.preventDefault();

        if (!confirm('この開催連絡を削除してもよろしいですか？')) {
            return;
        }

        var $button = $(this);
        var notificationId = $button.data('id');
        var $row = $button.closest('tr');

        $.ajax({
            url: tsn_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'tsn_delete_notification',
                id: notificationId,
                nonce: tsn_ajax.nonce
            },
            beforeSend: function() {
                $button.prop('disabled', true).text('削除中...');
            },
            success: function(response) {
                if (response.success) {
                    $row.fadeOut(400, function() {
                        $row.remove();
                        // 一覧が空になったらメッセージ表示
                        if ($('.wp-list-table tbody tr').length === 0) {
                            $('.wp-list-table').replaceWith('<p>開催連絡はまだ登録されていません。</p>');
                        }
                    });
                } else {
                    alert('削除に失敗しました: ' + response.data);
                    $button.prop('disabled', false).text('削除');
                }
            },
            error: function() {
                alert('通信エラーが発生しました。');
                $button.prop('disabled', false).text('削除');
            }
        });
    });

    // 編集ボタンクリック時（モーダルで編集する場合）
    $('.edit-notification-modal').on('click', function(e) {
        e.preventDefault();

        var notificationId = $(this).data('id');

        $.ajax({
            url: tsn_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'tsn_get_notification',
                id: notificationId,
                nonce: tsn_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    $('#notification_date').val(data.notification_date);
                    $('#message').val(data.message);
                    $('input[name="color"][value="' + data.color + '"]').prop('checked', true);
                    $('input[name="id"]').val(data.id);
                    updatePreview();

                    // フォームまでスクロール
                    $('html, body').animate({
                        scrollTop: $('#tsn-notification-form').offset().top - 50
                    }, 500);
                }
            }
        });
    });

    // フォーム送信前のバリデーション
    $('#tsn-notification-form').on('submit', function(e) {
        var date = $('#notification_date').val();
        var message = $('#message').val();
        var color = $('input[name="color"]:checked').val();

        if (!date) {
            alert('日付を選択してください。');
            $('#notification_date').focus();
            e.preventDefault();
            return false;
        }

        if (!message) {
            alert('メッセージを入力してください。');
            $('#message').focus();
            e.preventDefault();
            return false;
        }

        if (!color) {
            alert('表示色を選択してください。');
            e.preventDefault();
            return false;
        }

        return true;
    });

    // テーブルの行にホバー効果
    $('.wp-list-table tbody tr').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );

    // 今日の日付ボタン（追加機能）
    if ($('#notification_date').length) {
        var todayButton = $('<button type="button" class="button">今日</button>');
        todayButton.on('click', function(e) {
            e.preventDefault();
            var today = new Date();
            var formattedToday = today.getFullYear() + '-' +
                                ('0' + (today.getMonth() + 1)).slice(-2) + '-' +
                                ('0' + today.getDate()).slice(-2);
            $('#notification_date').val(formattedToday);
            updatePreview();
        });
        $('#notification_date').after(' ').after(todayButton);
    }
});