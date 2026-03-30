<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "Eindopdracht_P3");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get search and page from GET
$search = $_GET['search'] ?? '';
$page   = max(1, (int)($_GET['page'] ?? 1));
$perPage = 10;
$offset  = ($page - 1) * $perPage;

// Prepare search clause
$where = "";
$params = [];
if ($search !== '') {
    $where = "WHERE naam_bedrijf LIKE ? OR contact_persoon LIKE ?";
    $params = ["%$search%", "%$search%"];
}

// Fetch customers with pagination
$sql = "SELECT * FROM KlantenData $where ORDER BY bedrijf_id ASC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if ($search !== '') {
    $stmt->bind_param("ssii", $params[0], $params[1], $perPage, $offset);
} else {
    $stmt->bind_param("ii", $perPage, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

// Count total rows for pagination
$countSql = "SELECT COUNT(*) as total FROM KlantenData $where";
$countStmt = $conn->prepare($countSql);
if ($search !== '') $countStmt->bind_param("ss", $params[0], $params[1]);
$countStmt->execute();
$totalPages = ceil($countStmt->get_result()->fetch_assoc()['total'] / $perPage);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>Klantenlijst</title>

<!-- Include Bootstrap CSS for styling -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

    <!-- Header with page title and add new customer button -->
    <div class="d-flex justify-content-between mb-4">
        <h1>Klantenlijst</h1>
        <a href="klanttoevoegen.php" class="btn btn-success">Voeg nieuwe klant toe</a>
    </div>

    <!-- Search form -->
    <form class="mb-3" method="get">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Zoek klant..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary">Zoeken</button>
        </div>
    </form>

    <!-- Card containing the table -->
    <div class="card shadow">
        <div class="card-body">

            <!-- Table of customers -->
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th><th>Bedrijf</th><th>Contact</th><th>Adres</th><th>Telefoon</th><th>Acties</th>
                    </tr>
                </thead>
                <tbody>

                <!-- Check if there are any results -->
                <?php if ($result->num_rows): ?>

                    <!-- Loop through each row and display customer data -->
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row["bedrijf_id"] ?></td>
                            <td><?= $row["naam_bedrijf"] ?></td>
                            <td><?= $row["contact_persoon"] ?></td>
                            <td><?= $row["straatnaam"] . " " . $row["huisnummer"] ?><br><?= $row["postcode"] . " " . $row["woonplaats"] ?></td>
                            <td><?= $row["telefoonnummer"] ?></td>
                            <td>

                                <!-- Edit and delete buttons -->
                                <a href="wijzig.php?id=<?= $row["bedrijf_id"] ?>" class="btn btn-sm btn-warning">Wijzig</a>
                                <a href="verwijder.php?id=<?= $row["bedrijf_id"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Weet je zeker?')">Verwijder</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>

                    <!-- Display message if no customers found -->
                    <tr><td colspan="6" class="text-center">Geen klanten gevonden</td></tr>
                <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <!-- Previous page button -->
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">Vorige</a>
                    </li>
                    <!-- Page number buttons -->
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <!-- Next page button -->
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">Volgende</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>
</body>
</html>
