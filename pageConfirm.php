<?php
if (isset($_GET['id'])){
	$mysql = new mysqli("127.0.0.1", "socialuser2", "salutsalut", "mydb") or die('There was a problem connecting to the database');
	$stmt = $mysql->prepare('SELECT  tbl_composition.*,tbl_users.user_name FROM tbl_composition,tbl_users where tbl_users.id=tbl_composition.fk_user and id_composition = '.$_GET['id']);
	$stmt->execute();
	$stmt->bind_result($id_composition,$composition_name,$composition_rating, $style, $slotstyle,$slotpositions, $fk_user,$datecreation,$username);	
	$stmt->fetch();
	
	session_start();
	$pieces = explode(";", $_SESSION['alreadyliked']);
	if(in_array($id_composition, $pieces)){$temp=0;}else  {$temp=1;}
	
	echo '<script>';
	echo 'createBigCompositionConfirm('.$id_composition.','.$slotstyle.',['.$slotpositions.'],"#comp",'.$composition_rating.','.$temp.',"'.$composition_name.'","'.$username.'","'.$fk_user.'");';
	echo '</script>'; 
}
?>
<div id="comp"></div>