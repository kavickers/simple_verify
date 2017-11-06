<div class="container">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="container-box">
			<h1 style="font-weight:200;font-size:40px;">Discord Token</h1>
			<h3 class="h3-light" style="font-size:20px;">Please keep this token secret, and do not share it with anyone. You may re-generate it at anytime.</h3>
			<div style="height:25px;"></div>
				<form action="" method="POST">
					<h3 class="h3-light" style="font-size:18px;">Your Discord token is: <b><?php echo $myU->discordToken; //edit this here accordingly to how you retrieve certain values in a table?></b></h3>
					<div style="height:10px;"></div>
					<input class="blue-submit" type="submit" name="generate" value="Generate Token">
				</form>
		</div>
	</div>
	<div class="col-md-2"></div>
</div>


<?php
//please edit everything in this page accordingly! this was written originally for a website that utilized PDO in PHP, so please please please convert to mySQLi if you're using it!

$token = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
$generate = $_POST['generate']; //this corresponds with the name of the button input => [<input class="blue-submit" type="submit" name="generate" value="Generate Token">] <= note the name is equal to generate

if ($generate) {
	$gentoken = $handler->prepare("UPDATE users SET discordToken = :discord WHERE id = :id"); // again, same here, edit this accordingly to how you retrieve variables
	$gentoken->bindParam(':discord', $token);
	$gentoken->bindParam(':id', $myU->id); // again, same here, please edit accordingly to how you retrieve user variables [like the id]
	$gentoken->execute();
	header('Location: https://www.yourwebsite.com/discord'); // you can have it located in any type of file hierchy, just please edit it here!
}

?>
