--SQL Structure IDEAS:
-- Data structure for property:

create database empire_living;
use database empire_living;

create table property (
  PID  int auto_increment Primary key,
  title varchar(30),
  cost  int,
  square_feet  int,
  bedrooms  int,
  bathrooms  int,
  image_url  text, -- text data type is for rlly long string which can happen with image urls which can exceed 255 char
);

create table user (
  uername  varchar(50) Primary key,
  email    varchar(100),
  password varchar(100)
);
