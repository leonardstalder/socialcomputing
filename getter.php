<?php 

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
header('Content-Type: application/json');
if(isset($_GET['tbl'])){
//$mysql = new mysqli("127.0.0.1", "root", "", "mydb") or die('There was a problem connecting to the database');
$mysql = new mysqli("127.0.0.1", "socialuser2", "salutsalut", "mydb") or die('There was a problem connecting to the database');
}
else
{ echo "no";}
if($_GET['tbl']=="color"){




$stmt = $mysql->prepare('Select id_color,color_name from tbl_color');
$stmt->execute();
$stmt->bind_result($id,$nom);

$json = array();
while($row = $stmt->fetch()){


 $row_array['id'] = $id;
  $row_array['name'] =$nom;
 array_push($json,$row_array);

}
echo json_encode($json);

}
if($_GET['tbl']=="rating"){

session_start();
if (!isset($_SESSION['alreadyliked'])){
$_SESSION['alreadyliked'] = $_GET['id'];;
}else{
 $_SESSION['alreadyliked'] = $_SESSION['alreadyliked'].';'.$_GET['id'];}
 
 
$stmt = $mysql->prepare('UPDATE tbl_composition SET composition_rating=composition_rating+1 WHERE id_composition='.$_GET['id']);

if (!$stmt->execute()) {
   // echo "Echec lors de l'exécution de la requête : (" . $mysqli->errno . ") " . $mysqli->error;
     echo "error";
	 exit;
}else{
echo json_encode("ok");
exit;

}

}
if($_GET['tbl']=="addcompo"){

$compoName='"'.$_GET['compoName'].'"';
$catstyle=$_GET['catStyle'];
$compoCanevas=$_GET['compoCanevas'];
$compositionArray='"'.implode(json_decode($_GET['compositionArray']),',').'"';

//echo 'INSERT INTO tbl_composition (composition_name, composition_rating	, fk_style,slotstyle,slotpositions,fk_user) VALUES ('.$compoName.', 0, '.$catstyle.','.$compoCanevas.','.$compositionArray.',1)';
$stmt = $mysql->prepare('insert INTO tbl_composition (composition_name, composition_rating	, fk_style,slotstyle,slotpositions,fk_user) VALUES ('.$compoName.', 0, '.$catstyle.','.$compoCanevas.','.$compositionArray.','.$loggedInUser->user_id.')');
if (!$stmt->execute()) {
   // echo "Echec lors de l'exécution de la requête : (" . $mysqli->errno . ") " . $mysqli->error;
     echo "error";
	 exit;
}else{
$lastid= $stmt->insert_id;
foreach (json_decode($_GET['compositionArray']) as $tab ) 
{ 
$stmt2 = $mysql->prepare('INSERT INTO tbl_ref_compositionclothes (tbl_Composition_id_composition, tbl_clothes_id_cloth) VALUES ('.$lastid.', '.$tab.')');
if (!$stmt2->execute()) {
  //  echo "Echec lors de l'exécution de la requête : (" . $mysqli->errno . ") " . $mysqli->error;
  echo "error";
  exit;
}
}

}
echo json_encode($lastid);
exit;


}

if($_GET['tbl']=="searchcompo"){


$compositionArray='"'.implode(json_decode($_GET['compositionArray']),',').'"';

$requette='SELECT id_composition,slotpositions,slotstyle,composition_rating,composition_name FROM `tbl_composition` where id_composition in(SELECT DISTINCT tbl_Composition_id_composition
FROM  `tbl_ref_compositionclothes` 
WHERE  `tbl_clothes_id_cloth` IN('.$compositionArray.'))';


$stmt = $mysql->prepare($requette);
$stmt->execute();
$stmt->bind_result($id,$slotpos,$slotstyle,$rating,$composition_name);

$json = array();
while($row = $stmt->fetch()){


 $row_array['id'] = $id;
 $row_array['slotpos'] = $slotpos;
  $row_array['slotstyle'] = $slotstyle;
 
  $row_array['rating'] = $rating;
$row_array['componame'] = $composition_name;
 array_push($json,$row_array);

}
echo json_encode($json);

}


if($_GET['tbl']=="clothe"){

$requette='SELECT c.id_cloth ,o.color_name,s.seller_name,s.seller_website,cat.categorie_name,c.cloth_name as clothName FROM tbl_clothes as c,tbl_color as o,tbl_seller  as s,tbl_categorie as cat where c.fk_color=o.id_color and s.id_Seller=c.fk_seller and cat.id_Categorie =c.fk_categorie ';

if(is_numeric($_GET['color']))$requette.=' and c.fk_color ='.$_GET['color'];
if(is_numeric($_GET['categorie']))$requette.=' and c.fk_categorie ='.$_GET['categorie'];
if(is_numeric($_GET['seller']))$requette.=' and c.fk_seller ='.$_GET['seller'];



$stmt = $mysql->prepare($requette);
$stmt->execute();
$stmt->bind_result($id,$colorname,$selername,$sellerwebsite,$catname,$clothname);

$json = array();
while($row = $stmt->fetch()){


 $row_array['id'] = $id;
 $row_array['colorname'] = $colorname;
  $row_array['selername'] = $selername;
 $row_array['sellerwebsite'] = $sellerwebsite;
 $row_array['catname'] = $catname;
  $row_array['clothname'] = $clothname;
 array_push($json,$row_array);

}
echo json_encode($json);

}

if($_GET['tbl']=="seller"){

$stmt = $mysql->prepare('Select id_seller,seller_name,seller_website from tbl_seller');
$stmt->execute();
$stmt->bind_result($id,$nom,$website);

$json = array();
while($row = $stmt->fetch()){

    $row_array['id'] = $id;
    $row_array['name'] =$nom;
	   $row_array['website'] = $website;
 array_push($json,$row_array);
   
}
echo json_encode($json);
}
if($_GET['tbl']=="categorie"){
$stmt = $mysql->prepare('Select id_categorie,categorie_name from tbl_categorie');
$stmt->execute();
$stmt->bind_result($id,$nom);

$json = array();
while($row = $stmt->fetch()){
  $row_array['id'] = $id;
  $row_array['name'] = $nom;
 array_push($json,$row_array);
}
echo json_encode($json);
}


?>