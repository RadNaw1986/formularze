/*Komenty wpisane do bazy danych*/

/*Tworze nową baze*/
CREATE DATABASE formularze

/*Dodaje tabele do bazy formlarze*/
CREATE TABLE tabela (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  imie VARCHAR(255) NOT NULL,
  nazwisko VARCHAR(255) NOT NULL,
  plec VARCHAR(255) NOT NULL,
  haslo VARCHAR(255) NOT NULL,
  opcja VARCHAR(255) NOT NULL,
  komentarz TEXT,
  warunki VARCHAR(3) NOT NULL
);
