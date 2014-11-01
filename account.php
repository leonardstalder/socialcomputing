<?php


require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

$mysql = new mysqli("localhost", "socialuser2", "salutsalut", "mydb") or die('There was a problem connecting to the database');


?>
<body>

	<!-- header -->
	<div id="header">
		<?require_once("models/headerMenu.php");?>
	</div>
	<!-- end header -->
	
	<!-- shell -->
	<div class="shell">
		<div id="main" >
			<div id="content" class="clothesContainer">
			
			<?php
				$mysql = new mysqli("127.0.0.1", "socialuser2", "salutsalut", "mydb") or die('There was a problem connecting to the database');
		$stmt = $mysql->prepare('SELECT  tbl_composition.*,tbl_users.user_name FROM tbl_composition,tbl_users where tbl_users.id=tbl_composition.fk_user order by CreateDate DESC LIMIT 0, 100');
		$stmt->execute();
			$stmt->bind_result($id_composition,$composition_name,$composition_rating, $style, $slotstyle,$slotpositions, $fk_user,$creationDate,$username);	

			?>
				<?php while($row = $stmt->fetch()){
		
	?>
			
				<div style="position:relative; height: 450px; top:20px;">
					<div style="left: 150px; top: 20px; position:relative; width:150px;">
							<div style="float:left;"><img width="30px" style="border: 1px solid black;" src="http://forum.armslist.com/core/images/css/default_avatar_large.png"/></div>
							<div style="float:left; margin-left:5px;"><?php echo "<a href='profileUser.php?id=$fk_user'>$username</a>"; ?> </br><?php $timestamp = strtotime($creationDate); echo  date('d', $timestamp).'.'.date('m', $timestamp).'.'.date('Y', $timestamp);  ?></div>
					</div>
						
					<div  style=" width: 308px;  margin-left: auto; margin-right:auto;" id="compositions<?php echo $id_composition ?>" ></div>
				</div>

<?php 		
session_start();
	$pieces = explode(";", $_SESSION['alreadyliked']);
	if(in_array($id_composition, $pieces)){$temp=0;}else  {$temp=1;}

echo '<script>';
		echo ' createBigComposition('.$id_composition.','.$slotstyle.',['.$slotpositions.'],"#compositions'.$id_composition.'","'.$composition_rating.'",'.$temp.',"'.$composition_name.'","'.$username.'","'.$fk_user.'");';
		echo '</script>';}?>

		</div>
		<!-- end main -->
	
		<!-- footer -->
		<div id="footer">
			<?require_once("models/footer.php");?>
		</div>
		<!-- end footer -->
	</div>
	<!-- end shell -->
</body>
</html>