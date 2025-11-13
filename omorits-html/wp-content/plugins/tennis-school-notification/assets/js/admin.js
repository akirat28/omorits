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

    // ===========================
    // タブ切り替え機能
    // ===========================
    $('.tsn-view-tabs .tab-button').on('click', function() {
        var targetView = $(this).data('view');

        // タブのアクティブ状態を切り替え
        $('.tsn-view-tabs .tab-button').removeClass('active');
        $(this).addClass('active');

        // コンテンツの表示/非表示を切り替え
        $('.tsn-view-content').removeClass('active');
        $('#tsn-view-' + targetView).addClass('active');

        // 選択したビューをlocalStorageに保存
        localStorage.setItem('tsn_preferred_view', targetView);
    });

    // ページ読み込み時に前回のビュー選択を復元
    var preferredView = localStorage.getItem('tsn_preferred_view');
    if (preferredView) {
        $('.tsn-view-tabs .tab-button[data-view="' + preferredView + '"]').click();
    }

    // ===========================
    // カレンダー月切り替え機能
    // ===========================
    var currentYear = parseInt($('#tsn-calendar-year').val()) || new Date().getFullYear();
    var currentMonth = parseInt($('#tsn-calendar-month').val()) || new Date().getMonth() + 1;

    // 前月ボタン
    $('#tsn-calendar-prev').on('click', function() {
        currentMonth--;
        if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        }
        loadCalendar(currentYear, currentMonth);
    });

    // 次月ボタン
    $('#tsn-calendar-next').on('click', function() {
        currentMonth++;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }
        loadCalendar(currentYear, currentMonth);
    });

    // 今月ボタン
    $('#tsn-calendar-today').on('click', function() {
        var today = new Date();
        currentYear = today.getFullYear();
        currentMonth = today.getMonth() + 1;
        loadCalendar(currentYear, currentMonth);
    });

    // カレンダーを読み込む関数
    function loadCalendar(year, month) {
        var $calendarGrid = $('#tsn-calendar-grid');

        // ローディング表示
        $calendarGrid.html('<div style="grid-column: 1 / -1; text-align: center; padding: 2rem;"><span class="tsn-loading"></span> 読み込み中...</div>');

        $.ajax({
            url: tsn_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'tsn_get_calendar_data',
                year: year,
                month: month,
                nonce: tsn_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // カレンダータイトルを更新
                    $('#tsn-calendar-title').text(year + '年' + month + '月');

                    // 隠しフィールドを更新
                    $('#tsn-calendar-year').val(year);
                    $('#tsn-calendar-month').val(month);

                    // カレンダーグリッドを更新
                    $calendarGrid.html(response.data.html);

                    // カレンダー内のイベントを再バインド
                    bindCalendarEvents();
                } else {
                    $calendarGrid.html('<div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: #d63638;">エラー: ' + response.data + '</div>');
                }
            },
            error: function() {
                $calendarGrid.html('<div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: #d63638;">通信エラーが発生しました。</div>');
            }
        });
    }

    // カレンダー内のイベントをバインド
    function bindCalendarEvents() {
        // 通知クリックでモーダル表示
        $('.tsn-calendar-notification').on('click', function(e) {
            e.stopPropagation();
            var notificationId = $(this).data('id');
            showNotificationModal(notificationId);
        });

        // 編集ボタン
        $('.tsn-calendar-edit-btn').on('click', function(e) {
            e.stopPropagation();
            var notificationId = $(this).data('id');
            window.location.href = '?page=tennis-notification-add&edit=' + notificationId;
        });

        // 削除ボタン
        $('.tsn-calendar-delete-btn').on('click', function(e) {
            e.stopPropagation();
            var notificationId = $(this).data('id');

            if (confirm('この開催連絡を削除してもよろしいですか？')) {
                deleteNotification(notificationId);
            }
        });

        // 未入力の日付クリックで新規追加画面へ
        $('.tsn-calendar-day.no-notification').on('click', function(e) {
            var date = $(this).data('date');
            if (date) {
                window.location.href = '?page=tennis-notification-add&date=' + date;
            }
        });
    }

    // 初回バインド
    if ($('.tsn-calendar-grid').length) {
        bindCalendarEvents();
    }

    // 通知詳細モーダル表示
    function showNotificationModal(notificationId) {
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

                    // 日付フォーマット
                    var dateObj = new Date(data.notification_date);
                    var weekdays = ['日', '月', '火', '水', '木', '金', '土'];
                    var formattedDate = (dateObj.getMonth() + 1) + '月' + dateObj.getDate() + '日（' + weekdays[dateObj.getDay()] + '）';

                    // 色ラベル
                    var colorLabels = {
                        'green': '通常連絡',
                        'yellow': '注意連絡',
                        'red': '中止連絡'
                    };

                    // モーダルHTMLを生成
                    var modalHtml = '<div class="tsn-notification-modal active" id="tsn-notification-modal">' +
                                   '<div class="tsn-notification-modal-content">' +
                                   '<button class="tsn-notification-modal-close" id="tsn-modal-close">&times;</button>' +
                                   '<div class="tsn-notification-modal-header">' +
                                   '<h2 class="tsn-notification-modal-title">' + formattedDate + 'の開催連絡</h2>' +
                                   '<div class="tsn-notification-modal-date">' +
                                   '<span class="tsn-color-badge ' + data.color + '">' + colorLabels[data.color] + '</span>' +
                                   '</div>' +
                                   '</div>' +
                                   '<div class="tsn-notification-modal-body">' +
                                   '<div class="tsn-notification-modal-message">' + escapeHtml(data.message) + '</div>' +
                                   '</div>' +
                                   '<div class="tsn-notification-modal-footer">' +
                                   '<a href="?page=tennis-notification-add&edit=' + data.id + '" class="button button-primary">編集</a>' +
                                   '<button class="button tsn-modal-delete-btn" data-id="' + data.id + '">削除</button>' +
                                   '<button class="button" id="tsn-modal-close-btn">閉じる</button>' +
                                   '</div>' +
                                   '</div>' +
                                   '</div>';

                    // モーダルを追加
                    $('body').append(modalHtml);

                    // モーダルを閉じるイベント
                    $('#tsn-modal-close, #tsn-modal-close-btn').on('click', function() {
                        $('#tsn-notification-modal').remove();
                    });

                    // モーダル背景クリックで閉じる
                    $('#tsn-notification-modal').on('click', function(e) {
                        if ($(e.target).is('#tsn-notification-modal')) {
                            $('#tsn-notification-modal').remove();
                        }
                    });

                    // 削除ボタン
                    $('.tsn-modal-delete-btn').on('click', function() {
                        var id = $(this).data('id');
                        if (confirm('この開催連絡を削除してもよろしいですか？')) {
                            deleteNotification(id);
                            $('#tsn-notification-modal').remove();
                        }
                    });
                }
            }
        });
    }

    // 通知削除関数
    function deleteNotification(notificationId) {
        $.ajax({
            url: tsn_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'tsn_delete_notification',
                id: notificationId,
                nonce: tsn_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // カレンダーを再読み込み
                    var year = parseInt($('#tsn-calendar-year').val());
                    var month = parseInt($('#tsn-calendar-month').val());
                    if (year && month) {
                        loadCalendar(year, month);
                    } else {
                        location.reload();
                    }
                } else {
                    alert('削除に失敗しました: ' + response.data);
                }
            },
            error: function() {
                alert('通信エラーが発生しました。');
            }
        });
    }
});