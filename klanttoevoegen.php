<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "Eindopdracht_P3";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Use ?? to prevent undefined array key warnings
    $naam_bedrijf = $_POST["naam_bedrijf"] ?? '';
    $contact_persoon = $_POST["contact_persoon"] ?? '';
    $straatnaam = $_POST["straatnaam"] ?? '';
    $huisnummer = $_POST["huisnummer"] ?? '';
    $postcode = $_POST["postcode"] ?? '';
    $woonplaats = $_POST["woonplaats"] ?? '';
    $telefoonnummer = $_POST["telefoonnummer"] ?? '';

    // 🔐 Use prepared statements (prevents SQL injection)
    $stmt = $conn->prepare("INSERT INTO KlantenData 
        (naam_bedrijf, contact_persoon, straatnaam, huisnummer, postcode, woonplaats, telefoonnummer)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssss", 
        $naam_bedrijf, 
        $contact_persoon, 
        $straatnaam, 
        $huisnummer, 
        $postcode,
        $woonplaats,
        $telefoonnummer
    );

    if ($stmt->execute()) {
        echo "Nieuwe klant toegevoegd! <a href='index.php'>Terug naar klantenlijst</a>";
    } else {
        echo "Fout: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klant toevoegen</title>
</head>
<body>
    <h1>Klant toevoegen</h1>

    <form method="post" action="">
        <label>Naam Bedrijf:</label><br>
        <input type="text" name="naam_bedrijf" required><br><br>

        <label>Contact Persoon:</label><br>
        <input type="text" name="contact_persoon" required><br><br>

        <label>Straatnaam:</label><br>
        <input type="text" name="straatnaam"><br><br>

        <label>Huisnummer:</label><br>
        <input type="text" name="huisnummer"><br><br>

              <label>Postcode:</label><br>
        <input type="text" name="postcode"><br><br>
        
              <label>Woonplaats:</label><br>
        <input type="text" name="woonplaats"><br><br>

              <label>Telefoonnummer:</label><br>
        <input type="text" name="telefoonnummer"><br><br>

        <button type="submit">Opslaan</button>
    </form>
</body>
</html>