CREATE TABLE sky_api.category (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id));


  CREATE TABLE sky_api.posts (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(120) NOT NULL,
  category_id INT NOT NULL,
  description VARCHAR(500) NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT category_id
    FOREIGN KEY (category_id)
    REFERENCES sky_api.category (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);