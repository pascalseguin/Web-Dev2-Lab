<?php

function getGallerySQL() {
   $sql = 'SELECT GalleryID, GalleryName, GalleryNativeName, GalleryCity, GalleryCountry, Latitude, Longitude, GalleryWebSite FROM Galleries';
   $sql .= " ORDER BY GalleryName";
   return $sql;
}

function getPaintingSQL() {
    $sql = "SELECT PaintingID, Paintings.ArtistID AS ArtistID, FirstName, LastName, GalleryID, ImageFileName, Title, ShapeID, MuseumLink, AccessionNumber, CopyrightText, Description, Excerpt, YearOfWork, Width, Height, Medium, Cost, MSRP, GoogleLink, GoogleDescription, WikiLink, JsonAnnotations FROM Paintings INNER JOIN Artists ON Paintings.ArtistID = Artists.ArtistID  ";
    return $sql;
}

function addSortAndLimit($sqlOld) {
    $sqlNew = $sqlOld . " ORDER BY YearOfWork limit 20";
    return $sqlNew;
}

function makeArtistName($first, $last) {
    return utf8_encode($first . ' ' . $last);
}


/*
  You will likely need to implement functions such as these ...
*/
function getAllGalleries($connection) {
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $pdo->query(getGallerySQL());
        while ($row = $result->fetch()){
            echo "<option value=" . $row['GalleryID'] . ">" . $row['GalleryName'] . "</option>";
        }
        $pdo = null;
    }
    catch (PDOException $e){
        die($e->getMessage());
    }
}

function getAllPaintings($connection) {
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = addSortAndLimit(getPaintingSQL());
        $result = $pdo->query($sql);
        while ($row = $result->fetch()){
        ?>
    <li class="item">
            <a class="ui small image" href="single-painting.php?id=<?= $row['PaintingID']?>"><img src="images/art/works/square-medium/<?=$row['ImageFileName']?>.jpg"></a>
            <div class="content">
              <a class="header" href="single-painting.php?id=<?= $row['PaintingID']?>"><?= $row['Title']?></a>
              <div class="meta"><span class="cinema"><?= makeArtistName($row['FirstName'], $row['LastName'])?></span></div>        
              <div class="description">
                <p><?=$row['Excerpt']?></p>
              </div>
              <div class="meta">     
                  <strong><?=$row['MSRP']?></strong>        
              </div>        
            </div>      
          </li>
          <?php
     }
    $pdo = null;
}

catch (PDOException $e){
    die($e->getMessage());
}
}
function getPaintingsByGallery($connection) {
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = getPaintingSQL();
        $sql = $sql . "WHERE GalleryID=" . $_GET['museum'];
        $sql = addSortAndLimit($sql);
        $result = $pdo->query($sql);
        while ($row = $result->fetch()){
                ?>
            <li class="item">
                    <a class="ui small image" href="single-painting.php?id=<?= $row['PaintingID']?>"><img src="images/art/works/square-medium/<?=$row['ImageFileName']?>.jpg"></a>
                    <div class="content">
                      <a class="header" href="single-painting.php?id=<?= $row['PaintingID']?>"><?= $row['Title']?></a>
                      <div class="meta"><span class="cinema"><?= makeArtistName($row['FirstName'], $row['LastName'])?></span></div>        
                      <div class="description">
                        <p><?=$row['Excerpt']?></p>
                      </div>
                      <div class="meta">     
                          <strong><?=$row['MSRP']?></strong>        
                      </div>        
                    </div>      
                  </li>
                  <?php
         
        }
        $pdo = null;
    }
    catch (PDOException $e){
        die($e->getMessage());
    }
   
     
}



?>