#!/bin/bash
set -e

# テストデータをテーブルにロード
mariadb -uuser -ppass sample_db <<-EOSQL
LOAD DATA LOCAL INFILE '/docker-entrypoint-initdb.d/meas.tsv'
INTO TABLE measurements;
EOSQL

# テストデータの時刻を現在時刻に合わせて更新
## 最大のtimestamp(エポック秒)を取得
max_timestamp=$(mariadb -uuser -ppass -N -e "SELECT MAX(timestamp) FROM sample_db.measurements;")
## 現在時刻との差分を計算
current_timestamp=$(date +%s)
time_diff=$((current_timestamp - max_timestamp))
## 全てのレコードのtimestampをtime_diffだけ増やす
mariadb -uuser -ppass -e "UPDATE sample_db.measurements SET timestamp = timestamp + $time_diff ORDER BY timestamp DESC;"
