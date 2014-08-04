<!DOCTYPE html>
<?php 
include_once('config1.php');
$errors=array();
$success=array();

$committees = array(
					"Special Political and Decolonization Committee",
					"Disarmament and International Security",
					"Security Council",
					"World Health Organization",
					"High Commissioner for Refugees",
					"Office on Drugs and Crime",
					"Human Rights Council",
					"World Bank",
					"Paris Peace Conference",
					"Arab League",
					"Organization of American States",
					"International Criminal Court",
					"Association of Southeast Asian Nations",
					"Mao's Yan'An Red Base",
					"Cabinet of the Republic of Liberia",
					"Ukraine in Turmoil",
					"2050 National Security Council",
					"Israel-Hamas-Fatah Joint Crisis Committee"
);
$index = $_GET["committee"];

if (isset($_POST['editSubmit']) && $_POST['editSubmit'] == 'true') {
	$newChair = trim($_POST['chair']);
	$newEmail = trim($_POST['email']);
	$newBio = trim($_POST['bio']);
	$tempDir = sys_get_temp_dir();
	
	$query0 = "SELECT * FROM COMMITTEE_INFO WHERE Name=\"$committees[$index]\";";
	$result=mysql_query($query0);
	if (!$result) echo "Could not perform query. " . mysql_error();
	$row = mysql_fetch_assoc($result);
	$oldEmail = $row['email'];
	
	if (!eregi("^[^@]{1,64}@[^@]{1,255}$", $newEmail))
        $errors['newEmail'] = 'Your email address is invalid.';
		
	if (strlen($newBio) > 3000)
		$errors['newBio'] = 'Your bio cannot be longer than 3000 characters.';
	
	$ppAllowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["profilePhoto"]["name"]);
	$extension = end($temp);

if ((($_FILES["profilePhoto"]["type"] == "image/gif")
|| ($_FILES["profilePhoto"]["type"] == "image/jpeg")
|| ($_FILES["profilePhoto"]["type"] == "image/jpg")
|| ($_FILES["profilePhoto"]["type"] == "image/pjpeg")
|| ($_FILES["profilePhoto"]["type"] == "image/x-png")
|| ($_FILES["profilePhoto"]["type"] == "image/png"))
&& ($_FILES["profilePhoto"]["size"] < 20000)
&& in_array($extension, $ppAllowedExts)) {
  if ($_FILES["profilePhoto"]["error"] > 0) {
    $errors['newProfilePhoto'] = $_FILES["profilePhoto"]["error"];
  } else {
    if (file_exists(sys_get_temp_dir() . "/" . $_FILES["profilePhoto"]["name"])) {
      $errors['newProfilePhoto'] = $_FILES["profilePhoto"]["name"] . " already exists. ";
    } else {
      move_uploaded_file($_FILES["profilePhoto"]["tmp_name"],
      "docs/" . $_FILES["profilePhoto"]["name"]);
    }
  }
} else {
  $errors['newProfilePhoto'] = 'Invalid file type.';
} 
	$query1 = 'UPDATE COMMITTEE_INFO SET Leader="' . $newChair . '", Email="' . $newEmail . '", bio="' . $newBio . '", P_Filename="docs/' . $_FILES["profilePhoto"]["name"] . '" WHERE Name="' . $committees[$index] . '";';
	$query2 = 'UPDATE users SET email = "' . $newEmail . '" WHERE email="' . $oldEmail . '";';
	if (!$errors) {
        if (mysql_query($query1) && mysql_query($query2)) {
            $success['editCommitteeInfo'] = 'The committee information was updated.';
        }
        else {
            $error['editCommmitteeInfo'] = 'There was a problem updating the information. Please try again.';
        }
    }
}
?>
<html lang="en">
	<head>
		<!-- PACE LOADING BAR DEPENDENCIES -->
		<script src="js/pace.min.js"></script>
		<link href="css/pace-minimal.css" rel="stylesheet">

		<!-- BOOTSTRAP -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">

		<!-- GOOGLE FONTS -->
		<link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Quicksand:400,300,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Neuton:300,400,700,400italic' rel='stylesheet' type='text/css'>

		<!-- CUSTOM CSS -->
		<link href="css/index.css" rel="stylesheet">
		<link href="css/Template.css" rel="stylesheet">

		<title>PMUNC</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Princeton Model United Nations Conference">
		<meta name="keywords" content="PMUNC, MUN">
		<meta name="author" content="Clement Lee and Angelica Chen">

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- GOOGLE ANALYTICS -->
		<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51958755-1', 'princeton.edu');
  ga('send', 'pageview');

</script>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.html">Princeton Model United Nations Conference</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="index.html">Home</a></li>
						<li><a href="register.html">Register</a></li>
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Information <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="logistics.html">Logistics</a></li>
							<li><a href="schedule.html">Schedule</a></li>
							<li><a href="preparation.html">Preparation</a></li>
							<li><a href="faq.html">FAQ</a></li>
						</ul>
						</li>
						<li><a href="committees.php">Committees</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="https://www.facebook.com/PrincetonInternationalRelationsCouncil"><i class="fa fa-facebook"></i></a></li>
						<li><a href="http://irc.princeton.edu/"><i class="fa fa-globe"></i></a></li>
						<li><a href="mailto:pmunc@princeton.edu?Subject=PMUNC"><i class="fa fa-envelope"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container" id="template-container">
			<div class="container">
				<h1 class="text-center">Committee Management</h1>
				<div class="horbar">
				</div><br>
				<?php
				echo "<h3><b>Committee</b>: $committees[$index]</h3>";
				$query = "SELECT * FROM COMMITTEE_INFO WHERE Name=\"$committees[$index]\";";
				$result=mysql_query($query);
				if (!$result) echo "Could not perform query. " . mysql_error();
				$row = mysql_fetch_assoc($result);
				?>
				<h3><b>Chair(s)</b>: <?php echo $row['Leader']; ?></h3>
				<h3><b>Chair Email</b>: <?php echo $row['Email']; ?></h3>
				<h3><b>Chair Bio</b>:</h3> <p><?php echo $row['bio']; ?></p>
				<h3><b>Chair Photo</b>:<h3>
				<?php
				if ($row['P_Filename'] == NULL) echo "<p><i>No image has been uploaded.</i></p><br>"; 
				else echo "<img src=\"img/" . $row['P_Filename'] . "\" width=\"25%\"><br>";
				?>
				<h1 class="text-center">Edit Committee Info</h1>
				<div class="horbar"></div><br>
				<form name="editForm" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
                    <?php
                    if ($success['editCommitteeInfo'])
                        print "<div class=\"valid\">" . $success['editCommitteeInfo'] . "</div>";
                    if ($errors['editCommitteeInfo'])
                        print "<div class=\"invalid\">" . $errors['editCommitteeInfo'] . "</div>";
                    ?>
                    <h3><b>New chair(s)</b>:</h3><input type="text" name="chair" class="form-control" value="<?php echo $row['Leader']; ?>" required><br>
                    <h3><b>New chair email</b>:</h3><p>Please note that this will also change the email address associated with the committee chair account.</p>
					<input type="email" name="email" value="<?php echo $row['Email']; ?>" class="form-control" required><br>
                    <?php if ($errors['newEmail']) print "<div class=\"invalid\">" . $errors['newEmail'] . "</div>"; ?>
					<h3><b>New bio</b>:</h3><p>Maximum length of 3000 characters.</p>
					<?php if ($errors['newBio']) print "<div class=\"invalid\">" . $errors['newBio'] . "</div>"; ?>
					<textarea width=100% name="bio" class="form-control" maxlength=3000 required><?php echo $row['bio']; ?></textarea>
					<h3><b>New photo</b>:</h3><p>The photo must be either a GIF, JPG, or PNG. Maximum file size is 20 MB.</p>
					<?php if ($errors['newProfilePhoto']) print "<div class=\"invalid\">" . $errors['newProfilePhoto'] . "</div>"; echo $tempDir; ?>
					<input type="hidden" name="MAX_FILE_SIZE" value="20000">
					<input type="file" name="profilePhoto" id="profilePhoto"><br>
                    <input type="hidden" name="editSubmit" id="editSubmit" value="true">
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Submit">
                </form><br>
                <center><a href="dashboard.php"><button type="button" class="btn btn-link">Back to Dashboard</button></a></center>
			</div>
		</div>
		<div class="container container-footer">
			<div class="container">
				<footer>
					<p class="pull-right">Designed by Angelica Chen &amp; Clement Lee &middot; <a href="#">Back to top</a></p>
					<p class="pull-left">&copy; 2014 Princeton Model United Nations Conference </p>
				</footer>
			</div>
		</div>


		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</body>
</html>

