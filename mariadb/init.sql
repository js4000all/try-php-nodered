-- データベースの作成
CREATE DATABASE IF NOT EXISTS sample_db
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

-- ユーザーの作成と権限付与（必要に応じて）
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'pass';
GRANT ALL PRIVILEGES ON sample_db.* TO 'user'@'%';

-- テーブルの作成
USE sample_db;

CREATE TABLE IF NOT EXISTS measurements (
    sensor_id INT NOT NULL,
    timestamp BIGINT NOT NULL,
    value FLOAT NOT NULL,
    PRIMARY KEY (sensor_id, timestamp)
);
