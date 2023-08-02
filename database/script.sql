-- tạo DATABASE
CREATE DATABASE if not EXISTS PRODUCT_PHP;

-- sử dụng DATABASE
USE PRODUCT_PHP;

-- tạo bảng
create table if not exists users (
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL,
	password VARCHAR(50) NOT NULL UNIQUE
);

-- insert dữ liệu mẫu
insert into users (password, name, email) values
('1234', 'Nguyễn Chí Cao', 'abc@gmail.com'),
('1235', 'Nguyễn Văn A', 'dev@gmail.com'),
('1236', 'Trần Văn Tẻo', 'teo123@gmail.com');

create table if not EXISTS reset_password (
    id INT PRIMARY KEY AUTO_INCREMENT,
    token VARCHAR(100) NOT NULL,
    createAt DATETIME NOT NULL DEFAULT NOW(), -- thời điểm tạo token
    email VARCHAR(100) NOT NULL,
    avaiable BIT DEFAULT 1
);

-- tạo bảng categories
create table if not EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,
    image VARCHAR(1000) NOT NULL
);

-- insert dữ liệu mẫu
insert into categories (id, name, image) values
(1, 'Iphone', 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg'),
(2, 'Samsung', 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg'),
(3, 'Vivo', 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg');

-- tạo bảng products
create table if not EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
    description VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    quantity INT NOT NULL,
    image VARCHAR(5000) NOT NULL,
    categoryId INT NOT NULL,
    Foreign Key (categoryId) REFERENCES categories(id)
);



-- insert dữ liệu mẫu
insert into products (id, name, description, price, quantity, image, categoryId) values
(1, 'Sản phẩm 1', 'Điện thoại', 1000, 10, 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg', 1),
(2, 'Sản phẩm 2', 'Điện thoại', 1000, 10, 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg', 2),
(3, 'Sản phẩm 3', 'Điện thoại', 1000, 10, 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg', 3);