# tyatyablog
作ったはいいものの書くことそんなにないし、qiitaの方が書きやすいなということで閉鎖済みです。
参考になればと思いリポジトリを公開しています。
※デザイン知識等ないのでフロント部分は各々変更してください。また、SCSSの設計もずさんになっていますのでBEM記法にするなど変更されることを強くお勧めいたします。

# 記事投稿部の技術
管理画面の新規記事を押すと記事を書く画面に遷移します。
記事部分はMarkdownで書きたいなと思ったのでjsライブラリのSimple MDEというものを使用しております。
また、マークダウンで記述したものをHTMLに変換する必要があるのでPHPライブラリのcebe/markdownを使いました。
改行されない等の不具合があるのでqiitaを読むなりして拡張してください。
そして、コードのハイライトはprismというものを使ってます。
