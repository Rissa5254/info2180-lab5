<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");

// Check if the country parameter exists
if (isset($_GET['country'])){
  $country = $_GET['country'];

  // Preventing SQL Injection
  $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
  $stmt->execute(['country' => "%$country%"]);

  // Fetch results
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else{
  echo "Please provide a country using ?country=CountryName";
  exit;
}

?>
<!-- Display Results--->
<ul>
<?php if (!empty($results)): ?>  
  <?php foreach ($results as $row): ?>
    <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
  <?php endforeach; ?>
<?php else: ?>
  <li>No Results Found.</li>
<?php endif; ?>
</ul>
