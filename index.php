<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./master.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class= "container" id="contain">
      <h1>621AD-Programare examene</h1>
      <form id="form1"  method="post">
        <div class="form-group">
          <label style="display:inline;" for="sel1">Primul:</label>
          <select  class="form-control selection" id="sel1" name="Materie#1">
            <option value="API">Analiza si prelucrarea imaginilor</option>
            <option value="MEC">Mecanisme</option>
            <option value="BPTAC">Bazele proiectarii tehnologice asistate de calculator</option>
            <option value="OM">Organe de masini</option>
          </select>
          <label style="display:inline;" for="sel2">Al doilea:</label>
          <select class="form-control selection" id="sel2" name="Materie#2">
            <option value="API">Analiza si prelucrarea imaginilor</option>
            <option value="MEC">Mecanisme</option>
            <option value="BPTAC">Bazele proiectarii tehnologice asistate de calculator</option>
            <option value="OM">Organe de masini</option>
          </select>
          <label style="display:inline;" for="sel3">Al treilea:</label>
          <select class="form-control selection" id="sel3" name="Materie#3">
            <option value="API">Analiza si prelucrarea imaginilor</option>
            <option value="MEC">Mecanisme</option>
            <option value="BPTAC">Bazele proiectarii tehnologice asistate de calculator</option>
            <option value="OM">Organe de masini</option>
          </select>
            <label class="col-2" style="display:inline;" for="sel4">Al patrulea:</label>
            <select class="form-control selection col-10" id="sel4" name="Materie#4">
              <option value="API">Analiza si prelucrarea imaginilor</option>
              <option value="MEC">Mecanisme</option>
              <option value="BPTAC">Bazele proiectarii tehnologice asistate de calculator</option>
              <option value="OM">Organe de masini</option>
            </select>
            <input id="confirmation" type="hidden" name="id" value=''>
          <div id="press">
            <button class="btn btn-primary" id="submit" name="submit"  value="Submit">Submit</button>
            <!-- <button class="btn btn-success" id="changing" name="change"  value="Change">Change Optiuni</button> -->
            <button type="button" class="btn btn-info" id="results"  name="button">Rezultate</button>
          </div>
    </div>
  </div>
    </form>

    <script type="text/javascript">
      var ip;
      var exista = false;

    function first(){
      return(
        $.get("http://www.geoplugin.net/json.gp", function(data,status){

          ip = data.geoplugin_request;

        }, "json")
      );
      }

      function second(){
      return($.get("api.php",function(data,status){

          for(var i=0;i<data.length;i++){

            if(data[i].ID == ip){

              exista = true;

              break;
            }
          }

        },"json"));
      }
      first().then(second);

      $("#form1").submit(function(e){


        var mesaj = "Se pare ca ai mai completat deja formularul.Doresti sa faci o" +
         " schimbare?(Daca este prima oara cand completezi formularul si primesti mesajul acesta inseamna "+
         "ca esti conectat la o retea publica de internet.Incearca sa te conectezi la" +
          " o alta retea)";

        if(checkForDuplicates()){
          e.preventDefault();
          return;
        }

        if(exista){
          if(!confirm(mesaj)){
            e.preventDefault();
          }
        }

      });

      $("#results").click(function(){
        window.location.href="/results.php";
      });

      var selectii = document.getElementsByClassName("selection");
      function checkForDuplicates(){
        for(var i =0;i<selectii.length-1;i++){
          for(var j=i+1;j<selectii.length;j++){
            if(selectii[j].value==selectii[i].value){
              console.log(selectii[j].value);
              alert("2 sau mai multe campuri sunt identice");
              return true;
            }
          }
        }
        return false;
      }
    </script>
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

$usrIp = $_SERVER['REMOTE_ADDR'];


  $data = [];
  if(isset($_POST['submit'])){
    if(isset($_POST['Materie#1'])&&isset($_POST['Materie#2'])
        &&isset($_POST['Materie#3'])&&isset($_POST['Materie#4'])){
        $data['id'] = $usrIp;
        $data['op1'] = strip_tags(trim($_POST["Materie#1"]));
        $data['op2'] = strip_tags(trim($_POST["Materie#2"]));
        $data['op3'] = strip_tags(trim($_POST["Materie#3"]));
        $data['op4'] = strip_tags(trim($_POST["Materie#4"]));
    }
  try {
       $data2 = [];
       $pdo = new PDO($dsn, $user, $pass, $options);
       $sql2 = "SELECT ID FROM examen WHERE ID = '".$usrIp."'";
       $stmt2 = $pdo->query($sql2);
         foreach($stmt2 as $row){
           array_push($data2,$row['ID']);
         }

       if(empty($data2)&&checkFields($data)){

           $sql = "INSERT INTO optiuni.examen (ID,optiune1,optiune2,optiune3,optiune4) VALUES(:id,:op1,:op2,:op3,:op4)";
           $stmt = $pdo->prepare($sql);
           $stmt->execute($data);

        }else{


              $sql3 = "UPDATE examen SET optiune1=:op1,optiune2=:op2,optiune3=:op3,optiune4=:op4 WHERE ID=:id";
              $stmt = $pdo->prepare($sql3);
              $stmt->execute($data);

              saveRejected($data);
              exit;

          }
  } catch (PDOException $e) {
     throw new PDOException($e->getMessage(), (int)$e->getCode());
  }
}

function checkFields($datas){
  unset($datas['id']);
  $materii = ['MEC','API','BPTAC','OM'];
  foreach($datas as $field){
    if(in_array($field,$materii)===false){
      return false;
    }
  }
  return true;
}
function saveRejected($array1){
  $myfile = fopen("data.txt",'a');
  fwrite($myfile,"\n");
  foreach($array1 as $element){
    fwrite($myfile,$element." ");
  }
  fclose($myfile);
}
exit;
?>
