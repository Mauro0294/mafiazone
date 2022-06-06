CREATE TABLE autos (
  id int AUTO_INCREMENT,
  model varchar(255),
  img_url varchar(255),
  waarde int,
  PRIMARY KEY (id)
);

INSERT INTO autos (id, model, img_url, waarde) VALUES
('Audi TT', 'https://www.autoscout24.nl/assets/auto/images/model/audi/audi-tt/audi-tt-l-02.jpg', 30000),
('Volkswagen Golf GTI', 'https://media.autoweek.nl/m/bkfydb0bmpbp_800.jpg', 45000),
('Lamborghini Aventador', 'https://www.autoblog.nl/files/2021/07/lamborghini-aventador-ultimae-2021-970-023.jpg', 450000),
('Range Rover Evoque', 'https://media.autoweek.nl/m/5p7yd2vb64bb_800.jpg', 50000),
('BMW M5', 'https://www.hartvoorautos.nl/wp-content/uploads/2020/06/2021-BMW-M5-Competition-1.jpg', 150000);
('Fiat 500', 'https://images.ctfassets.net/tmk3oi6u1mmf/61LGbQn55IEhfLcg29Rh6B/4fed5dfd6dc0d68d3494d7132370c779/ATX_M671_F5.jpg?fm=webp&w=648', 20000),
('Mercedes-Benz CL 500', 'https://www.autoscout24.nl/assets/auto/images/model/mercedes-benz/mercedes-benz-cl-500/mercedes-benz-cl-500-l-01.jpg', 25000),
('Toyota GR Supra', 'https://media.autoweek.nl/m/db3y4x0bw3mu_800.jpg', 70000),
('Rolls Royce Phantom', 'https://alle-autos.nl/uploads/2019/02/Rolls-Royce%20Phantom%201.jpg', 550000),
('Renault Megane', 'https://media.autoweek.nl/m/8tgyeyobnkpc_800.jpg', 25000)

CREATE TABLE autostelen_timers (
  user_id int,
  date int
);

CREATE TABLE garage (
  user_id int,
  auto_id int
);

CREATE TABLE messages (
  id int(11) AUTO_INCREMENT,
  afzender varchar(255),
  bericht varchar(255),
  PRIMARY KEY (id)
);

CREATE TABLE misdaad_timers (
  user_id int(11),
  date int(11)
);

CREATE TABLE sporthal_timers (
  user_id int(11),
  date int(11)
);

CREATE TABLE users (
  id int(11) AUTO_INCREMENT,
  gebruikersnaam varchar(255),
  email varchar(255),
  wachtwoord varchar(255),
  cashgeld int(11),
  bankgeld int(11),
  power int(11),
  kogels int(11),
  credits int(11),
  moorden int(11),
  gezondheid int(11),
  banned varchar(255),
  admin varchar(255),
  PRIMARY KEY (id)
);

CREATE TABLE cooldowns (
	id int(11) AUTO_INCREMENT,
  event varchar(255),
  time int(11),
  PRIMARY KEY (id)
);

CREATE TABLE methlab (
    id int(11) AUTO_INCREMENT,
    user_id int(11),
    time int(11),
    PRIMARY KEY (id)
);

INSERT INTO cooldowns (event, time) VALUES
('misdaad', 90),
('auto_stelen', 180),
('sporthal', 600);

ALTER TABLE garage
  ADD CONSTRAINT `garage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `garage_ibfk_2` FOREIGN KEY (`auto_id`) REFERENCES `autos` (`id`);

ALTER TABLE misdaad_timers
  ADD CONSTRAINT `misdaad_timers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);