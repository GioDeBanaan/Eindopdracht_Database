<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "Eindopdracht_P3";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}

// Variable for success/error message
$succes = "";

// Get customer ID from query parameter
$bedrijf_id = $_GET['id'] ?? null;

// Redirect if no ID is provided
if (!$bedrijf_id) {
    header("Location: index.php");
    exit;
}

// Fetch current customer data
$stmt = $conn->prepare("SELECT * FROM KlantenData WHERE bedrijf_id = ?");
$stmt->bind_param("i", $bedrijf_id);
$stmt->execute();
$result = $stmt->get_result();
$klant = $result->fetch_assoc();

// Check if customer exists
if (!$klant) {
    die("Klant niet gevonden.");
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get updated data from form
    $naam_bedrijf = $_POST["naam_bedrijf"] ?? '';
    $contact_persoon = $_POST["contact_persoon"] ?? '';
    $straatnaam = $_POST["straatnaam"] ?? '';
    $huisnummer = $_POST["huisnummer"] ?? '';
    $postcode = $_POST["postcode"] ?? '';
    $woonplaats = $_POST["woonplaats"] ?? '';
    $telefoonnummer = $_POST["telefoonnummer"] ?? '';

    // Prepared statement to update customer
    $stmt = $conn->prepare("UPDATE KlantenData SET 
        naam_bedrijf = ?, 
        contact_persoon = ?, 
        straatnaam = ?, 
        huisnummer = ?, 
        postcode = ?, 
        woonplaats = ?, 
        telefoonnummer = ? 
        WHERE bedrijf_id = ?");

    $stmt->bind_param("sssssssi", 
        $naam_bedrijf, 
        $contact_persoon, 
        $straatnaam, 
        $huisnummer, 
        $postcode, 
        $woonplaats, 
        $telefoonnummer, 
        $bedrijf_id
    );

    // Execute update and show message
    if ($stmt->execute()) {
        $succes = "Klantgegevens succesvol bijgewerkt!";
        
        // Refresh current data
        $klant = [
            "naam_bedrijf" => $naam_bedrijf,
            "contact_persoon" => $contact_persoon,
            "straatnaam" => $straatnaam,
            "huisnummer" => $huisnummer,
            "postcode" => $postcode,
            "woonplaats" => $woonplaats,
            "telefoonnummer" => $telefoonnummer
        ];
    } else {
        $succes = "Fout bij bijwerken: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klant wijzigen</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<h1 class="text-center my-4">Klant wijzigen</h1>

<?php if (!empty($succes)): ?>

    <!-- Success or error message -->
    <div class="alert alert-success text-center">
        <?= $succes ?>
        <br>
        <a href="index.php" class="btn btn-sm btn-primary mt-2">Terug naar klantenlijst</a>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Klantgegevens aanpassen</h4>
        </div>

        <div class="card-body">

            <!-- Edit customer form -->
            <form method="post" action="">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Naam Bedrijf</label>
                        <input type="text" name="naam_bedrijf" class="form-control" value="<?= htmlspecialchars($klant['naam_bedrijf']) ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Persoon</label>
                        <input type="text" name="contact_persoon" class="form-control" value="<?= htmlspecialchars($klant['contact_persoon']) ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Straatnaam</label>
                        <input type="text" name="straatnaam" class="form-control" value="<?= htmlspecialchars($klant['straatnaam']) ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Huisnummer</label>
                        <input type="text" name="huisnummer" class="form-control" value="<?= htmlspecialchars($klant['huisnummer']) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Postcode</label>
                        <input type="text" name="postcode" class="form-control" value="<?= htmlspecialchars($klant['postcode']) ?>">
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="form-label">Woonplaats</label>
                        <input type="text" name="woonplaats" class="form-control" value="<?= htmlspecialchars($klant['woonplaats']) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefoonnummer</label>
                    <input type="text" name="telefoonnummer" class="form-control" value="<?= htmlspecialchars($klant['telefoonnummer']) ?>">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Terug</a>
                    <button type="submit" class="btn btn-success">Opslaan</button>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>