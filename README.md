# Klantbeheersysteem (PHP & MySQL)
Dit is een eenvoudig Klantbeheersysteem gemaakt met PHP, MySQL en Bootstrap. Met dit systeem kun je klanten toevoegen, bekijken, wijzigen en verwijderen. De interface is responsief dankzij Bootstrap.

### Installatie in XAMPP:

Plaats het project in htdocs van XAMPP, bijvoorbeeld C:\xampp\htdocs\CustomerManagement.
Start Apache en MySQL via XAMPP Control Panel.
Open phpMyAdmin (http://localhost/phpmyadmin) en maak een database Eindopdracht_P3.
Maak de tabel KlantenData met deze SQL:
CREATE TABLE KlantenData (
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

Open het project in je browser via http://localhost/CustomerManagement/klantenlijst.php. Gebruik “➕ Nieuwe klant” om toe te voegen, “✏️ Wijzigen” om te bewerken en “🗑️ Verwijderen” om te verwijderen.

Bestanden:

klantenlijst.php – Klantenlijst
jouwformulierpagina.php – Klant toevoegen
wijzig.php – Klant bewerken
verwijder.php – Klant verwijderen
README.md – Documentatie
