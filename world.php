<?php

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try{
  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check if the country parameter exists
  if (isset($_GET['country'])){
    $country = $_GET['country'];

    // Check if the cities parameter exists
    if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities'){
      $stmt = $conn->prepare("SELECT cities.name AS city, cities.district, cities.population 
                              FROM cities JOIN countries ON cities.country_code = countries.code
                              WHERE countries.name LIKE :country");
      $stmt->execute(['country' => "%$country%"]);
      // Fetch results
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      //-- Display Results as a HTML Table---
      if (!empty($results)){   
        echo "<table border = '1'>";
        echo "<tr>
                <th>City Name</th>
                <th>District</th>
                <th>Population</th>
              </tr>";

        foreach ($results as $row){
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['city']) . "</td>";
          echo "<td>" . htmlspecialchars($row['district']) . "</td>";
          echo "<td>" . htmlspecialchars($row['population']) . "</td>";
          echo "</tr>";
        }
        echo "</table>";
      }else{
        echo "No Cities Found.";
      }
    } else{
      // Preventing SQL Injection
      $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
      $stmt->execute(['country' => "%$country%"]);

      // Fetch results
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        echo "No Country Found.";
      }
    } 
  } else{
    echo "<p>Please provide a country using ?country=CountryName</p>";
    echo "<p>Please provide cities using ?country=CountryName&lookup=cities</p>";
  }
} catch(PDOException $e){
  echo "Connectiion failed: " . $e -> getMessage();
  exit;
}

?>
