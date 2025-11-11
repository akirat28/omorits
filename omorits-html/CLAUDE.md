# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## プロジェクト概要

大森テニスクラブの会員制サイト。WordPress をベースとしたカスタムテーマで構成されている。

## ディレクトリ構造

```
omorits-html/
├── wp-content/
│   └── themes/
│       └── omori-tennis-club/    # カスタムテーマディレクトリ
│           ├── style.css          # テーマスタイルシート（テーマ情報を含む）
│           ├── functions.php      # テーマ機能とフック
│           ├── header.php         # サイトヘッダー
│           ├── footer.php         # サイトフッター
│           ├── index.php          # デフォルトテンプレート
│           ├── page-home.php      # HOMEページ専用カスタムテンプレート
│           └── README.md          # テーマのセットアップ手順
├── wp-config.php                  # WordPress設定（Docker環境変数対応）
└── その他WordPress標準ファイル
```

## テーマアーキテクチャ

### テーマ識別と基本情報
`wp-content/themes/omori-tennis-club/style.css` のヘッダーコメントにテーマ情報が定義されている。このファイルがテーマの存在を WordPress に認識させる最も重要なファイル。

### テンプレート階層
- `page-home.php`: "HOMEページ" というカスタムページテンプレート。WordPress管理画面で固定ページ作成時に選択可能
- `index.php`: フォールバックテンプレート（通常のページや投稿用）
- `header.php`, `footer.php`: 共通パーツ（`get_header()`, `get_footer()` で呼び出し）

### テーマ機能登録（functions.php）
以下の機能が `functions.php` で登録されている：
- **メニュー位置**: `primary`（プライマリーメニュー）, `footer`（フッターメニュー）
- **ウィジェットエリア**: `sidebar-1`, `footer-1`
- **テーマサポート**: title-tag, post-thumbnails, html5
- **フィルター**: 抜粋長さ（100文字）、抜粋末尾（"..."）

### page-home.php の構造
HOMEページテンプレートは以下のセクションで構成：
1. **ヒーローセクション** (`.home-hero`): タイトル、サブタイトル、CTAボタン
2. **特徴セクション** (`.features-section`): 6つの特徴カード（`.feature-card`）
3. **お知らせセクション** (`.news-section`): WP_Query で最新投稿3件を取得・表示
4. **アクセスセクション** (`.access-section`): 住所・営業時間・地図プレースホルダー
5. **お問い合わせセクション**: CTAボタン

## WordPress管理画面での設定が必要な項目

HOMEページを表示するには、コードだけでなく以下の管理画面操作が必須：

1. **テーマ有効化**: 「外観」→「テーマ」→「大森テニスクラブ」を有効化
2. **固定ページ作成**: 「固定ページ」→「新規追加」でタイトル「HOME」、テンプレート「HOMEページ」を選択して公開
3. **フロントページ設定**: 「設定」→「表示設定」→「ホームページの表示」を「固定ページ」に変更し、作成した「HOME」ページを選択

詳細は `wp-content/themes/omori-tennis-club/README.md` 参照。

## スタイリング設計

### カラーパレット
- **メインカラー**: `#1e3c72`, `#2a5298`（青系グラデーション）
- **アクセントカラー**: `#4CAF50`（緑系）
- **背景**: `#f8f9fa`, `#2c3e50`（フッター）

### レスポンシブブレークポイント
`@media (max-width: 768px)` でモバイル対応。ヘッダーとグリッドレイアウトが縦積みに変化。

## 環境設定

WordPress は Docker 対応（`wp-config.php` が環境変数を使用）。以下の環境変数でデータベース接続を設定：
- `WORDPRESS_DB_NAME`, `WORDPRESS_DB_USER`, `WORDPRESS_DB_PASSWORD`, `WORDPRESS_DB_HOST`

## コンテンツ更新時の注意点

### 住所・電話番号の変更
`footer.php` と `page-home.php` の両方に記載されているため、両ファイルを更新する必要がある。

### 地図の埋め込み
`page-home.php` の line 111-116 にプレースホルダーがあり、Google Maps の iframe に置き換える想定。

### お知らせ（投稿）の表示
`page-home.php` の line 68-92 で WP_Query を使用して最新投稿3件を自動取得。WordPress の「投稿」機能で記事を追加すると自動的にHOMEページに反映される。

## テーマファイル編集時の原則

- **インラインスタイルの多用**: `page-home.php` 内に多くのインラインスタイルが存在。デザイン変更時は `style.css` への移行を検討
- **テンプレート識別**: カスタムページテンプレートには冒頭に `Template Name:` コメントが必須
- **WordPress関数の活用**: `get_header()`, `get_footer()`, `wp_nav_menu()`, `dynamic_sidebar()` など標準関数を使用
