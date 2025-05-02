--SQL Structure IDEAS:
-- Data structure for property:

create database empire_living;
use empire_living;

CREATE TABLE property (
  property_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(30) NOT NULL,
  cost INT NOT NULL,
  square_feet INT NOT NULL,
  bedrooms INT NOT NULL,
  bathrooms INT NOT NULL,
  image LONGBLOB,
  location varchar(50) NOT NULL, -- this is the short info like neighborhood of where it is for the cards
  address varchar(255) NOT NULL,
  sold BOOLEAN DEFAULT FALSE,
  description TEXT
);

create table user (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(20) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL
);

CREATE TABLE agent (
  agent_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL
);

create table appointment (
  appointment_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  property_id INT NOT NULL,
  agent_id INT NOT NULL,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user(user_id),
  FOREIGN KEY (agent_id) REFERENCES agent(agent_id),
  FOREIGN KEY (property_id) REFERENCES property (property_id)
);
