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

  //-- Display Results as a HTML Table---
  if (!empty($results)){
    echo "<table border = '1'>";
    echo "<tr>
            <th>Country Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
          </tr>";
    
    foreach ($results as $row){
      echo "<tr>";
      echo "<td>" . htmlspecialchars($row['name']) . "</td>";
      echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
      echo "<td>" . htmlspecialchars($row['independence_year']) . "</td>";
      echo "<td>" . htmlspecialchars($row['head_of_state']) . "</td>";
      echo "</tr>";
    }
    echo "</table>";
  }else{
      echo "No Results Found.";
    }

} else{
  echo "Please provide a country using ?country=CountryName";
  exit;
}

?>
