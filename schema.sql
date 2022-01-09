DROP DATABASE IF EXISTS taskforce;
CREATE DATABASE IF NOT EXISTS taskforce
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE taskforce;

-- Таблица городов
CREATE TABLE IF NOT EXISTS city (
  id SMALLINT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR (50) NOT NULL
);

-- Таблица user. Данные о зарегистрированных пользователях
CREATE TABLE IF NOT EXISTS user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  login VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  avatar VARCHAR(255) NOT NULL,
  create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  birthdate YEAR,
  info TEXT(300),
  phone VARCHAR(20) NOT NULL,
  telegram VARCHAR(50),
  user_role VARCHAR(20) NOT NULL,
  city_id SMALLINT COMMENT 'Связь с полем id таблицы city',
  UNIQUE uk_email (email)
  );

-- Таблица task. Данные о заданиях, сохраненных на сайте
CREATE TABLE IF NOT EXISTS task (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  title VARCHAR(255) NOT NULL,
  customer_id INT NOT NULL COMMENT 'Связь с полем id таблицы user',
  performer_id INT COMMENT 'Связь с полем id таблицы user',
  status VARCHAR(50) NOT NULL,
  deadline_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  description TEXT NOT NULL,
  budget DECIMAL(10.2) NOT NULL DEFAULT 0,
  location VARCHAR(255),
  city_id SMALLINT COMMENT 'Связь с полем id таблицы city',
  INDEX idx_customer_id (customer_id) COMMENT 'Индекс поля customer_id',
  INDEX idx_performer_id (performer_id) COMMENT 'Индекс поля performer_id',
  INDEX idx_city_id (city_id) COMMENT 'Индекс поля city_id',
  FOREIGN KEY fk_customer_id (customer_id) REFERENCES user (id),
  FOREIGN KEY fk_performer_id (performer_id) REFERENCES user (id),
  FOREIGN KEY fk_city_id (city_id) REFERENCES city (id)
);

-- Таблица category. Доступные категории заданий
CREATE TABLE IF NOT EXISTS category (
  id SMALLINT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR (50) NOT NULL,
  UNIQUE uk_title (title)
);

-- Таблица связей task_category. Данные о категориях заданий
CREATE TABLE IF NOT EXISTS task_category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL COMMENT 'Связь с полем id таблицы task',
  category_id SMALLINT NOT NULL COMMENT 'Связь с полем id таблицы category',
  INDEX idx_task_id (task_id) COMMENT 'Индекс поля task_id',
  INDEX idx_category_id (category_id) COMMENT 'Индекс поля category_id',
  FOREIGN KEY fk_task_id (task_id) REFERENCES task (id),
  FOREIGN KEY fk_category_id (category_id) REFERENCES category (id)
);

-- Таблица с данными о прикрепленных файлах
CREATE TABLE IF NOT EXISTS attachment (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL COMMENT 'Индекс поля task_id',
  url VARCHAR (255) NOT NULL,
  INDEX idx_task_id (task_id) COMMENT 'Индекс поля task_id',
  FOREIGN KEY fk_task_id (task_id) REFERENCES task (id)
);

-- Таблица связей. Данные о профессиональных сферах деятельности исполнителей
CREATE TABLE IF NOT EXISTS user_category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  performer_id INT NOT NULL COMMENT 'Связь с полем id таблицы user',
  category_id SMALLINT NOT NULL COMMENT 'Связь с полем id таблицы category',
  INDEX idx_performer_id (performer_id) COMMENT 'Индекс поля performer_id',
  INDEX idx_category_id (category_id) COMMENT 'Индекс поля category_id',
  FOREIGN KEY fk_performer_id (performer_id) REFERENCES user (id),
  FOREIGN KEY fk_category_id (category_id) REFERENCES category (id)
);

-- Таблица откликов пользователей на задания
CREATE TABLE IF NOT EXISTS respond (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL COMMENT 'Связь с полем id таблицы task',
  text TEXT(500),
  budget DECIMAL(10.2) NOT NULL DEFAULT 0,
  performer_id int NOT NULL COMMENT 'Связь с полем id таблицы user',
  INDEX idx_task_id (task_id) COMMENT 'Индекс поля task_id',
  INDEX idx_performer_id (performer_id) COMMENT 'Индекс поля performer_id',
  FOREIGN KEY fk_task_id (task_id) REFERENCES task (id),
  FOREIGN KEY fk_performer_id (performer_id) REFERENCES user (id)
);

-- Таблица отзывов заказчиков о работе исполнителей
CREATE TABLE IF NOT EXISTS review (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  customer_id INT NOT NULL COMMENT 'Связь с полем id таблицы user',
  performer_id INT NOT NULL COMMENT 'Связь с полем id таблицы user',
  task_id INT NOT NULL COMMENT 'Связь с полем id таблицы task',
  text TEXT NOT NULL,
  rating SMALLINT NOT NULL,
  INDEX idx_performer_id (performer_id) COMMENT 'Индекс поля performer_id',
  FOREIGN KEY fk_performer_id (performer_id) REFERENCES user (id),
  FOREIGN KEY fk_customer_id (customer_id) REFERENCES user (id),
  FOREIGN KEY fk_task_id (task_id) REFERENCES task (id)
);
