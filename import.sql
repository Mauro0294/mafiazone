CREATE TABLE autos (
  id int AUTO_INCREMENT,
  model varchar(255),
  img_url varchar(255),
  waarde int,
  PRIMARY KEY (id)
);

INSERT INTO autos (id, model, img_url, waarde) VALUES
(1, 'Audi TT', 'https://www.autoscout24.nl/assets/auto/images/model/audi/audi-tt/audi-tt-l-02.jpg', 30000),
(2, 'Volkswagen Golf GTI', 'https://media.autoweek.nl/m/bkfydb0bmpbp_800.jpg', 45000),
(3, 'Lamborghini Aventador', 'https://www.autoblog.nl/files/2021/07/lamborghini-aventador-ultimae-2021-970-023.jpg', 450000),
(4, 'Range Rover Evoque', 'https://media.autoweek.nl/m/5p7yd2vb64bb_800.jpg', 50000),
(5, 'BMW M5', 'https://www.hartvoorautos.nl/wp-content/uploads/2020/06/2021-BMW-M5-Competition-1.jpg', 150000);

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
  PRIMARY KEY (id)
);

ALTER TABLE garage
  ADD CONSTRAINT `garage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `garage_ibfk_2` FOREIGN KEY (`auto_id`) REFERENCES `autos` (`id`);

ALTER TABLE misdaad_timers
  ADD CONSTRAINT `misdaad_timers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);