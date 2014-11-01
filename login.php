<?php


require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$username = sanitize(trim($_POST["username"]));
	$password = trim($_POST["password"]);
	
	//Perform some validation
	//Feel free to edit / change as required
	if($username == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
	}
	if($password == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}

	if(count($errors) == 0)
	{
		//A security note here, never tell the user which credential was incorrect
		if(!usernameExists($username))
		{
			$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
		}
		else
		{
			$userdetails = fetchUserDetails($username);
			//See if the user's account is activated
			if($userdetails["active"]==0)
			{
				$errors[] = lang("ACCOUNT_INACTIVE");
			}
			else
			{
				//Hash the password and use the salt from the database to compare the password.
				$entered_pass = generateHash($password,$userdetails["password"]);
				
				if($entered_pass != $userdetails["password"])
				{
					//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
					$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
				}
				else
				{
					//Passwords match! we're good to go'
					
					//Construct a new logged in user object
					//Transfer some db data to the session object
					$loggedInUser = new loggedInUser();
					$loggedInUser->email = $userdetails["email"];
					$loggedInUser->user_id = $userdetails["id"];
					$loggedInUser->hash_pw = $userdetails["password"];
					$loggedInUser->title = $userdetails["title"];
					$loggedInUser->displayname = $userdetails["display_name"];
					$loggedInUser->username = $userdetails["user_name"];
					
					//Update last sign in
					$loggedInUser->updateLastSignIn();
					$_SESSION["userCakeUser"] = $loggedInUser;
					
					//Redirect to user account page
					header("Location: account.php");
					die();
				}
			}
		}
	}
}


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
					<?php echo resultBlock($errors,$successes)?>
					<form name='login' action='<? echo $_SERVER['PHP_SELF'];?>' method='post'>
					<p>
					<label>Username:</label>
					<input type='text' name='username' />
					</p>
					<p>
					<label>Password:</label>
					<input type='password' name='password' />
					</p>
					<p>
					<label>&nbsp;</label>
					<input type='submit' value='Login' class='submit' />
					</p>
					</form>
					</br>
					</br>
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


