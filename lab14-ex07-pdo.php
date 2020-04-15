<?php require_once('config.inc.php');?>
<!DOCTYPE html>
<html>
<body>
<h1>Database Tester (PDO)</h1>
<?php
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from Artists order by Lastname";
    $result = $pdo->query($sql);
    while ($row = $result->fetch()){
        echo $row['ArtistID'] . " - " . $row['Lastname'] . "<br/>"; 
    }
    $pdo = null;
}
catch (PDOException $e){
    die($e->getMessage());
}
?>
</body>
</html>