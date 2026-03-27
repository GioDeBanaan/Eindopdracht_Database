# Klantbeheersysteem (PHP & MySQL)
Dit is een eenvoudig Klantbeheersysteem gemaakt met PHP, MySQL en Bootstrap. Met dit systeem kun je klanten toevoegen, bekijken, wijzigen en verwijderen. De interface is responsief dankzij Bootstrap.

### Installatie in XAMPP:

Plaats het project in htdocs van XAMPP, bijvoorbeeld C:\xampp\htdocs\Eindopdracht.
Start Apache en MySQL via XAMPP Control Panel.
Open phpMyAdmin (http://localhost/phpmyadmin) en maak een database eindopdracht_p3.
Maak de tabel KlantenData met deze SQL:
CREATE TABLE klantendata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naam_bedrijf VARCHAR(255) NOT NULL,
    contact_persoon VARCHAR(255) NOT NULL,
    straatnaam VARCHAR(255),
    huisnummer VARCHAR(10),
    postcode VARCHAR(10),
    woonplaats VARCHAR(255),
    telefoonnummer VARCHAR(50)
);
Zorg dat de PHP-bestanden de juiste databaseverbinding gebruiken:
<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "Eindopdracht_P3";

$conn = new mysqli($host, $user, $pass, $dbname);
?>

Open het project in je browser via http://localhost/Eindopdracht/klantenlijst.php. Gebruik “Nieuwe klant” om toe te voegen, “Wijzig” om te bewerken en “Verwijder” om te verwijderen.
