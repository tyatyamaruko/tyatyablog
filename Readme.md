# ちゃちゃブログ
技術ブログ、日常ブログとして制作する

## 技術選定
- PHP
  server side lang Main
- SCSS
  cascading style sheet
- HTML
  mark up lang
- JQuery
  front end lang
- Svelte
  front end lang
- SimpleMDE
  preview mark down lang
- cebe/markdown
  parse mark down lang
- code-prettify
  syntacs high light code
- AWS EC2

## 技術ブログについて
>入力項目
- ジャンル
- タイトル
- 記事の内容(Markdown)

> 実装機能
- コメント
- いいね

> 実装の流れ

>> 投稿部
- basic認証
- 入力された値をpostしてジャンル、タイトル、markdownのファイル名をデータベースに保存
- markdownファイルをサーバーに保存

>> コメント部
- コメント主の匿名の名前を入力
- IPアドレス、コメント、名前、コメントの日時をデータベースに保存

>database

|column   |type      |length|other       |require
|---------|----------|------|------------|--------
|id       |int       |      |primary key | true
|title    |varchar   |    64|            | true
|genre    |varchar   |    32|            | true
|markdown |mediumtext|      |            | true
|timestamp|timestamp |      |            | true