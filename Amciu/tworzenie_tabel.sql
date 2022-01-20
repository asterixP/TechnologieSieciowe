CREATE DATABASE pasibrzuch CHARACTER SET UTF8mb4 collate utf8mb4_bin;

USE pasibrzuch;

CREATE TABLE IF NOT EXISTS Klienci (
  IdKlienta INT PRIMARY KEY AUTO_INCREMENT,
  Imie VARCHAR(30) NOT NULL,
  Nazwisko VARCHAR(30) NOT NULL,
  Adres VARCHAR(50) NOT NULL,
  Telefon VARCHAR(9) NOT NULL,
  Miasto VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS Zamowienia (
  IdZamowienia INT PRIMARY KEY AUTO_INCREMENT,
  DataZamowienia DATETIME NOT NULL,
  DataRealizacji DATETIME NOT NULL,
  IdKlienta INT NOT NULL REFERENCES Klienci(IdKlienta)
);

CREATE TABLE Kategorie (
  IdKategorii INT PRIMARY KEY AUTO_INCREMENT,
  Nazwa VARCHAR(30) NOT NULL
);

CREATE TABLE Potrawy (
  IdPotrawy INT PRIMARY KEY AUTO_INCREMENT,
  Nazwa VARCHAR(50) NOT NULL,
  Obrazek VARCHAR(50) NOT NULL,
  IdKategorii INT NOT NULL REFERENCES Kategorie(IdKategorii),
  Cena DECIMAL(5, 2) NOT NULL
);

CREATE TABLE IF NOT EXISTS Koszyk (
  IdZamowienia INT NOT NULL REFERENCES Zamowienia(IdZamowienia),
  IdPotrawy INT NOT NULL REFERENCES Potrawy(IdPotrawy),
  Ilosc INT NOT NULL,
  UNIQUE(IdZamowienia, IdPotrawy)
);