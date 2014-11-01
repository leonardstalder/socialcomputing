<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

if (!securePage($_SERVER['PHP_SELF'])){die();}

//Links for logged in user
if(isUserLoggedIn()) {
	echo "
	<div id='menuHolder'>
		<div style='float:left;' class='navigationDiv'><a title='Home' href='account.php'><span alt='Home'><img height='28px'  src='css/images/home_icon.png'/></span></a></div>
		<div style='float:left;' class='navigationDiv'><a title='Discover' href='recherche.php'><span alt='Discover'><img height='28px' src='css/images/searc_icon.png'></span></a></div>
		<div style='float:left;' class='navigationDiv'><a title='Create' href='clothes.php''><span alt='Create'><img height='28px' src='css/images/create.png'></span></a></div>
		<div style='float:left; width: 276px; height: 37px; padding-left:180px;'><a href='index.php'><img src='css/images/logo.png'/></a></div>
		<div  style='float:right;' class='navigationDiv'><a title='Logout' href='logout.php'><span alt='Logout'><img height='28px' src='css/images/logout.png'></span></a></div>
		<div style='float:right;' class='navigationDiv'><a title='Parameters' href='user_settings.php'><span alt='Parameters'><img height='28px' src='css/images/parameters.png'></span></a></div>
		<div style='float:right;' class='navigationDiv'><a title='Me' href='profileUser.php''><span alt='Me'><img height='28px' src='css/images/profile_icon.png'></span></a></div>
		
	</div>
	";
	
	//Links for permission level 2 (default admin)
	if ($loggedInUser->checkPermission(array(2))){
	echo "
	<ul style='margin-top: 50px; position:absolute;'>
	<li><a href='admin_configuration.php'>Admin Configuration</a></li>
	<li><a href='admin_users.php'>Admin Users</a></li>
	<li><a href='admin_permissions.php'>Admin Permissions</a></li>
	<li><a href='admin_pages.php'>Admin Pages</a></li>
	</ul>";
	}
} 
//Links for users not logged in
else {
	echo "
	<a style='color:white;' href='login.php'>Login</a>  
	<a style='color:white;' href='register.php'>Register</a>
	
	
	";
	if ($emailActivation && 1==0)
	{
	echo "<li><a href='resend-activation.php'>Resend Activation Email</a></li>";
	}
	echo "</ul>";
}

?>
