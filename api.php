<?php

  $host = "127.0.0.1";
  $db = "optiuni";
  $user  = "root";
  $pass = "";
  $charset = "utf8mb4";
  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
  $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
  ];

  $SQL = "SELECT ID FROM examen";
  $data = [];
  try{

    $pdo = new PDO($dsn, $user, $pass, $options);
    $stmt = $pdo->query($SQL);

    foreach($stmt as $row){
      //var_dump($row);
      array_push($data,$row);
    }
    //var_dump($data);
    echo json_encode($data);

  }catch(PDOException $e){
    throw new PDOException($e->getMessage(), (int)$e->getCode());
  }

?>
