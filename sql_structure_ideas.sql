--SQL Structure IDEAS:
-- Data structure for property:

create database empire_living;
use empire_living;

create table user (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(20) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  role varchar(10) NOT NULL DEFAULT 'user'
);

CREATE TABLE property (
  property_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL, -- who posted it
  title VARCHAR(30) NOT NULL,
  cost INT NOT NULL,
  square_feet INT NOT NULL,
  bedrooms INT NOT NULL,
  bathrooms INT NOT NULL,
  image LONGBLOB,
  location VARCHAR(50) NOT NULL, -- short label (like neighborhood)
  address VARCHAR(255) NOT NULL, -- full address for details page
  sold BOOLEAN DEFAULT FALSE,
  description TEXT,
  FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE agent (
  agent_id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) NOT NULL,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL
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

-- Creating Agents
INSERT INTO agent (email, first_name, last_name) VALUES ('john.smith@empire-living.com', 'John', 'Smith');
INSERT INTO agent (email, first_name, last_name) VALUES ('frederick.jefferson@empire-living.com', 'Frederick', 'Jefferson');
INSERT INTO agent (email, first_name, last_name) VALUES ('annabelle.smalls@empire-living.com', 'Annabelle', 'Smalls');
