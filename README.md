# Klantbeheersysteem (PHP & MySQL)

Dit is een eenvoudig **Klantbeheersysteem** gemaakt met **PHP**, **MySQL** en **Bootstrap**.  
Met dit systeem kun je klanten **toevoegen**, **bekijken**, **wijzigen** en **verwijderen** via een gebruiksvriendelijke interface.  

De interface is volledig **responsief** dankzij Bootstrap.

---

## Bestanden in dit project

- `index.php` – De klantenlijst, met zoekfunctie en paginering.
- `klanttoevoegen.php` – Voeg een nieuwe klant toe aan de database.
- `wijzig.php` – Pas bestaande klantgegevens aan.
- `verwijder.php` – Verwijder een klant na bevestiging.
- `README.md` – Dit bestand met instructies.

---

## Installatie in XAMPP

1. Plaats het project in de **htdocs** map van XAMPP, bijvoorbeeld:  
   `C:\xampp\htdocs\Eindopdracht`
2. Start **Apache** en **MySQL** via het XAMPP Control Panel.
3. Open **phpMyAdmin**: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
4. Maak een database genaamd `Eindopdracht_P3`.
5. Maak de tabel `KlantenData` met deze SQL:

```sql
CREATE TABLE KlantenData (
    bedrijf_id INT AUTO_INCREMENT PRIMARY KEY,
    naam_bedrijf VARCHAR(255) NOT NULL,
    contact_persoon VARCHAR(255) NOT NULL,
    straatnaam VARCHAR(255),
    huisnummer VARCHAR(10),
    postcode VARCHAR(10),
    woonplaats VARCHAR(255),
    telefoonnummer VARCHAR(50)
);
