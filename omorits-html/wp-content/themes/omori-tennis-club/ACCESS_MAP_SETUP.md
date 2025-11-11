# アクセスセクション 地図埋め込みガイド

## 📍 概要
トップページのアクセスセクションに、実際のGoogle Mapsを埋め込む方法を説明します。

## 🗺️ Google Maps 埋め込み手順

### 1. Google Mapsで場所を検索
1. [Google Maps](https://maps.google.com) を開く
2. 「東京都大田区大森北1-2-3」または施設名で検索
3. 正しい場所が表示されていることを確認

### 2. 埋め込みコードを取得
1. 場所の詳細が表示されたら、「共有」ボタンをクリック
2. 「地図を埋め込む」タブを選択
3. サイズを選択（「中」または「カスタムサイズ」推奨）
4. 「HTMLをコピー」をクリック

### 3. コードを設置

`page-home.php` の **262-270行目** のコメント部分を以下のように置き換えます：

#### 現在のコード（プレースホルダー）
```html
<!-- 実際のGoogle Maps埋め込みコード例 -->
<!-- <iframe
    src="https://maps.google.com/maps?q=東京都大田区大森北1-2-3&output=embed"
    width="100%"
    height="100%"
    style="border:0;"
    allowfullscreen=""
    loading="lazy">
</iframe> -->
```

#### 置き換え後（実際の埋め込み）
```html
<iframe
    src="取得したGoogleMapsのURL"
    width="100%"
    height="100%"
    style="border:0; border-radius: 20px;"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">
</iframe>
```

### 4. プレースホルダーを削除
地図を埋め込んだら、以下のプレースホルダー要素を削除またはコメントアウト：

```html
<!-- プレースホルダーを削除またはコメントアウト -->
<!--
<svg class="map-icon" width="80" height="80" viewBox="0 0 80 80" fill="none">
    ...
</svg>
<p class="map-text">Google Maps</p>
<p class="map-instruction">地図を読み込み中...</p>
-->
```

## 🎨 カスタマイズオプション

### 地図のスタイル調整
CSSで地図コンテナのスタイルを調整できます：

```css
.map-container {
    height: 600px;  /* 高さを調整 */
    border-radius: 20px;  /* 角丸 */
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

/* モバイル用の高さ調整 */
@media (max-width: 768px) {
    .map-container {
        height: 350px;
    }
}
```

### 代替案: OpenStreetMap
Google Maps以外の選択肢として、OpenStreetMapも利用可能：

```html
<iframe
    width="100%"
    height="100%"
    frameborder="0"
    scrolling="no"
    marginheight="0"
    marginwidth="0"
    src="https://www.openstreetmap.org/export/embed.html?bbox=経度,緯度,経度,緯度&layer=mapnik&marker=緯度,経度"
    style="border: 0; border-radius: 20px;">
</iframe>
```

## 📝 実装例（完全版）

```php
<!-- 左側：地図 -->
<div class="access-map-wrapper" data-aos="fade-right">
    <div class="map-container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3243.123456789!2d139.7234567!3d35.6234567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2s東京都大田区大森北1-2-3!5e0!3m2!1sja!2sjp!4v1234567890"
            width="100%"
            height="100%"
            style="border:0; border-radius: 20px;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>
```

## 🔧 トラブルシューティング

### Q: 地図が表示されない
**A:** 以下を確認してください：
- URLが正しくコピーされているか
- iframeタグが正しく閉じられているか
- インターネット接続が正常か

### Q: 地図の位置がずれている
**A:** Google Mapsで正確な位置を再検索し、新しい埋め込みコードを取得してください

### Q: スマートフォンで地図が小さい
**A:** CSS の `.map-container` の高さを調整してください

## 💡 ヒント

1. **APIキーの使用**（上級者向け）
   - Google Maps APIを使用すると、より詳細なカスタマイズが可能
   - [Google Cloud Console](https://console.cloud.google.com/)でAPIキーを取得

2. **複数のピンを表示**
   - 駐車場の位置など、複数の場所を表示したい場合はGoogle My Mapsを使用

3. **ストリートビュー**
   - 施設の外観を見せたい場合は、ストリートビューの埋め込みも検討

## 🎯 推奨設定

| 項目 | 推奨値 |
|-----|--------|
| 地図の高さ（PC） | 600px |
| 地図の高さ（モバイル） | 350px |
| ズームレベル | 16-17 |
| 地図タイプ | 通常の地図 |

## 📞 サポート

実装で問題が発生した場合は、以下の情報と共にお問い合わせください：
- 使用しているブラウザ
- エラーメッセージ（ある場合）
- 埋め込みコード

---
更新日: 2024年
大森テニスクラブテーマ アクセスセクション設定ガイド