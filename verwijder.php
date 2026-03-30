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

// Get customer ID from query parameter
$bedrijf_id = $_GET['id'] ?? null;

// Redirect if no ID is provided
if (!$bedrijf_id) {
    header("Location: index.php");
    exit;
}

// Variable for success/error message
$succes = "";

// Check if deletion is confirmed via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Prepared statement to delete customer
    $stmt = $conn->prepare("DELETE FROM KlantenData WHERE bedrijf_id = ?");
    $stmt->bind_param("i", $bedrijf_id);

    if ($stmt->execute()) {
        $succes = "Klant succesvol verwijderd!";
    } else {
        $succes = "Fout bij verwijderen: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klant verwijderen</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Klant verwijderen</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($succes)): ?>

                <!-- Success or error message -->
                <div class="alert alert-success text-center">
                    <?= $succes ?>
                    <br>
                    <a href="index.php" class="btn btn-sm btn-primary mt-2">Terug naar klantenlijst</a>
                </div>
            <?php else: ?>
                
                <!-- Confirmation form -->
                <p class="text-center">Weet je zeker dat je deze klant wilt verwijderen?</p>
                <form method="post" class="text-center">
                    <button type="submit" class="btn btn-danger">Ja, verwijderen</button>
                    <a href="index.php" class="btn btn-secondary">Annuleren</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>