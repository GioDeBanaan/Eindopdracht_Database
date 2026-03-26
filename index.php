<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "Eindopdracht_P3";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}

// Query to fetch all customers
$sql = "SELECT * FROM KlantenData";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>klantenlijst</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <!-- Header with title and add new customer button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📋 Klantenlijst</h1>
        <a href="klanttoevoegen.php" class="btn btn-success">➕ Voeg nieuwe klant toe</a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <!-- Table to display all customers -->
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Bedrijf</th>
                        <th>Contact</th>
                        <th>Addres</th>
                        <th>Telefoon</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                // Check if there are any customers
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Display each customer row
                        echo "<tr>
                            <td>".$row["bedrijf_id"]."</td>
                            <td>".$row["naam_bedrijf"]."</td>
                            <td>".$row["contact_persoon"]."</td>
                            <td>".$row["straatnaam"]." ".$row["huisnummer"]."<br>
                                ".$row["postcode"]." ".$row["woonplaats"]."</td>
                            <td>".$row["telefoonnummer"]."</td>
                            <td>
                        
                                <a href='wijzig.php?id=".$row["bedrijf_id"]."' class='btn btn-sm btn-warning'>✏️</a>
                                <a href='verwijder.php?id=".$row["bedrijf_id"]."' 
                                   class='btn btn-sm btn-danger'
                                   onclick='return confirm(\"Are you sure you want to delete this customer?\")'>🗑️</a>
                            </td>
                        </tr>";
                    }
                } else {
                    // Message if no customers found
                    echo "<tr><td colspan='6' class='text-center'>No customers found</td></tr>";
                }
                ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>