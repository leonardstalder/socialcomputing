<?php


require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

$searchforId=$loggedInUser->user_id;

if(isset($_GET["id"]))$searchforId=$_GET["id"];



	$mysql = new mysqli("127.0.0.1", "socialuser2", "salutsalut", "mydb") or die('There was a problem connecting to the database');
	$stmt = $mysql->prepare('SELECT  tbl_composition.*,tbl_users.user_name,tbl_users.display_name FROM tbl_composition,tbl_users where tbl_users.id=tbl_composition.fk_user and tbl_composition.fk_user ='.$searchforId);
	$stmt->execute();
	$stmt->bind_result($id_composition,$composition_name,$composition_rating, $style, $slotstyle,$slotpositions, $fk_user,$creationDate,$username,$displayname );	

?>
<script>



$( document ).ready(function() {	
	<? while($row = $stmt->fetch()){
		echo ' createComposition('.$id_composition.','.$slotstyle.',['.$slotpositions.'],"#compositions","'.$composition_name.'");';
	}?>
	$('#compositions').append('<div style="clear:both"></div>');
});	

function openmodal(id){
$('<div></div>').load('page.php?id='+id).modal({onShow: function (d) {
    // replace '0px' with your value, or remove the property
    d.container.css({ top: '70px',height: '374px'});
}}); // AJAX

}


</script>
<body>
	<!-- header -->
	<div id="header">
		<?require_once("models/headerMenu.php");?>
	</div>
	<!-- end header -->
	
	<!-- shell -->
	<div class="shell">
		<div id="main" >
			
			<div class="userTopBar" >
				<div style="float:left;">
				<img style="border: 1px solid black; height:100px;" src="http://forum.armslist.com/core/images/css/default_avatar_large.png"/>
				</div>
				<div style="float:left; padding:10px;">
				<h2><? echo $username?></h2>
				<p><? echo $displayname?></p>
				</div>
				<div style="float:left;">
				</div>
			</div>
			
							
			<div id="content" class="clothesContainerSpecial">
			
			<div id="compositions">
			
			</div>
			
			
			
			</div>
			


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