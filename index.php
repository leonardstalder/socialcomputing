<?php


require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }


require_once("models/header.php");
?>

<body>

	<!-- header -->
	<div id="header" style="height:50px; ">
		<div id="navigation" style="height:300px;">
			
		</div>
	</div>
	<!-- end header -->
	
	<!-- shell -->
	<div class="shell" >
		<div id="main">

			<div style="float:left; width:455px; height:500px;" >
			<img src="css/images/homeScreen.png" />
			</div>
			
			<div style="float:left; width:455px; height:500px;">
			
				<img style="padding-top:25px;" src="css/images/logo.png"/>
				
				<div style="padding: 10px;">
				<?php
					include("left-nav.php");
				?>
				</div>
				<div id='regbox' style="background-color:#efefef; padding:10px; border-radius:10px;">
				<h2>Fashion is you</h2></br>
				<p>FashionSource allows people, that are interested in fashion, to create combinations of clothes and to share it.</p></br>
				<p>Be the designer of tomorrow by creating beautiful clothes combinations by using layouts and our large database of clothes.</p>

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