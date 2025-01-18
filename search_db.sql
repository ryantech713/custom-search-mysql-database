CREATE DATABASE search_db;

USE search_db;

CREATE TABLE items (
   id INT AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(255) NOT NULL,
   description TEXT
);

INSERT INTO items (name, description) VALUES
  ('Apple', 'A fruit that is red, green, or yellow'),
  ('Banana', 'A long, yellow fruit'),
  ('Carrot', 'An orange vegetable'),
  ('Dragon Fruit', 'A tropical fruit with a unique look');