# admin-server
クライアント及びその他の管理者のみが使用できるサーバー。IPのアクセス制限をかける。  
※このプロジェクトは以下のプロジェクトの環境構築が必要です。  
 ・[bicycle_system(駐輪場管理システム)](https://github.com/projectd-team14/bicycle_system)  
## 環境構築  
〇主要フレームワーク、ライブラリ、言語等  
・Laravel(PHP)  
・Node.js  
〇使用ツール  
・Docker(必須)  
1.リポジトリのclone
```
git clone https://github.com/projectd-team14/admin-server.git
```
2.admin-serverディレクトリに移動
```
cd admin-server
```
3.各ディレクトリでDockerイメージのビルド
```
docker compose up -d --build
```
4-1.admin-serverのコンテナに接続
```
docker container exec -it admin-server-php-1 bash
cd admin-server
composer install
```
