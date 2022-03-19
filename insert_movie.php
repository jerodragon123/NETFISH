<?php
class Reservation {
  // (A) PROPERTIES
  private $conn; // PDO object
  private $stmt; // SQL statement
  public $e; // Error message

  // (D) SAVE RESERVATION
  function save ($title, $url, $year, $description) {
    include("DBconfig.php");
    include("library/mails.php");
    $alert = "";

    // (D2) DATABASE ENTRY
    try {
      $sql = "INSERT INTO `movie` (`title`, `url`, `year`, `description`) VALUES (?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($title, $url, $year, $description));
    } catch(PDOException $e) {
      $alert = "Kon geen reservatie maken.";
      $e->getMessage();
    }
  }
}

// (F) DATABASE SETTINGS
// ! CHANGE THESE TO YOUR OWN !
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'test');
// define('DB_CHARSET', 'utf8');
// define('DB_USER', 'root');
// define('DB_PASSWORD', '');

// (G) NEW RESERVATION OBJECT
$_RSV = new Reservation();