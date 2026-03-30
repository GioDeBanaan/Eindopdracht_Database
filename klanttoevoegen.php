<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "Eindopdracht_P3";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variable for success/error message
$success = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get data from form, prevent undefined index
    $bedrijfs_naam = $_POST["naam_bedrijf"] ?? '';
    $contact_persoon = $_POST["contact_persoon"] ?? '';
    $straat = $_POST["straatnaam"] ?? '';
    $huisnummer = $_POST["huisnummer"] ?? '';
    $postcode = $_POST["postcode"] ?? '';
    $woonplaats = $_POST["woonplaats"] ?? '';
    $telefoonnummer = $_POST["telefoonnummer"] ?? '';

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO KlantenData 
        (naam_bedrijf, contact_persoon, straatnaam, huisnummer, postcode, woonplaats, telefoonnummer)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssss", 
        $bedrijfs_naam, 
        $contact_persoon, 
        $straat, 
        $huisnummer, 
        $postcode,
        $woonplaats,
        $telefoonnummer
    );

    // Execute query and give message
    if ($stmt->execute()) {
        $success = "New customer added!";
    } else {
        $success = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voeg klant toe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<h1 class="text-center my-4">Voeg klant toe</h1>

<?php if (!empty($success)): ?>
    <!-- Success or error message -->
    <div class="alert alert-success text-center">
        <?php echo $success; ?>
        <br>
        <a href="index.php" class="btn btn-sm btn-primary mt-2">Terug naar klantenlijst</a>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Voeg klant toe</h4>
        </div>

        <div class="card-body">

            <!-- Form -->
            <form method="post" action="">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bedrijfsnaam</label>
                        <input type="text" name="naam_bedrijf" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contactpersoon</label>
                        <input type="text" name="contact_persoon" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Straat</label>
                        <input type="text" name="straatnaam" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Huisnummer</label>
                        <input type="text" name="huisnummer" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Postcode</label>
                        <input type="text" name="postcode" class="form-control">
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="form-label">Woonplaats</label>
                        <input type="text" name="woonplaats" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefoonnummer</label>
                    <input type="text" name="telefoonnummer" class="form-control">
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
