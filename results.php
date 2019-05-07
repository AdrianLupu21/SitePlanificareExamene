<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title></title>
  </head>
  <body>

  </body>
</html>
<?php
$host = '127.0.0.1';
$db   = 'optiuni';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);
$sql = "SELECT optiune1,optiune2,optiune3,optiune4 FROM optiuni.examen";

$data = $pdo->query($sql);
echo "<table class='table'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>Optiune1</th>
            <th scope='col'>Optiune2</th>
            <th scope='col'>Optiune3</th>
            <th scope='col'>Optiune4</th>
          </tr>
        </thead>";
$i= 1;
$arr = [[]];
foreach($data as $row){
    for($l=0;$l<sizeof($row);$l++){
      $arr[$i-1][$l] = $row["optiune".($l+1)];
    }
  echo '<tbody>
        <tr>
          <th scope="row">'.$i.'</th>
          <td>'.$row["optiune1"].'</td>
          <td>'.$row["optiune2"].'</td>
          <td>'.$row["optiune3"].'</td>
          <td>'.$row["optiune4"].'</td>
        </tr>';
  $i++;
}
echo "</tbody></table>";
echo "<table class='table' id='table'>
        <thead>
          <tr>
            <th style='text-align:center;' scope='col' colspan='5'> Optiunile populare</th>
          </tr>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>Optiune1</th>
            <th scope='col'>Optiune2</th>
            <th scope='col'>Optiune3</th>
            <th scope='col'>Optiune4</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td> 1  </td>";
        foreach(checkTheMostWanted($arr) as $row){
          echo '<td>'.$row.'</td>';
            }
            echo '</tr> </tbody>';
function checkTheMostWanted($arr){
  $x=0;
  $elem='';
  $search=[];
  for($i=0;$i<sizeof($arr[0]);$i++){
    for($j=0;$j<sizeof($arr);$j++){
      if(countTheElements($arr,$i,$arr[$j][$i],sizeof($arr))>$x){
        $x = countTheElements($arr,$i,$arr[$j][$i],sizeof($arr));
        $elem = $arr[$j][$i];
      }
    }
    array_push($search,$elem);
    $x=0;
  }
  return $search;
}
function countTheElements($arr,$j,$value,$length){
  $s = 0;
  if(empty($arr[$length-1])){
    return;
  }
  for($k=0;$k<$length;$k++){
    if($value == $arr[$k][$j]){
      $s++;
    }

  }
  return $s;
}
  ?>
