<!doctype html>
<?php
	require_once('connect.php');
	$saveType = TRUE;
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.css">
	<link href="css/all.css" rel="stylesheet">

	<!-- Sidebar CSS -->
	<link rel="stylesheet" href="sidebarstyle.css">

    <title>Test Script</title>
  </head>
  <body>
  	<div class="wrapper">
		<!-- Sidebar (thanks to bootstrapious.com and Ondrej Svestka)  -->
		<nav id="sidebar" class="active">
			<div class="sidebar-header">
				<h4><i class="fas fa-list-alt"></i> Menu</h4>
			</div>

			<ul class="list-unstyled components">
				<li>
					<a href="sessions.php"><i class="fas fa-list"></i> Oturum Listesi</a>
				</li>
				<li>
					<a href="#"><i class="fas fa-history"></i> Geçmiş Oturumlar</a>
				</li>
				<li>
					<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-toggle-sidebar"><i class="fas fa-chart-bar"></i> İstatistikler</a>
					<ul class="collapse list-unstyled" id="pageSubmenu">
						<li>
							<a href="#">Page 1</a>
						</li>
						<li>
							<a href="#">Page 2</a>
						</li>
						<li>
							<a href="#">Page 3</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#"><i class="fas fa-list-ol"></i> Öğretmen Listesi</a>
				</li>
				<li>
					<a href="#"><i class="far fa-envelope"></i> İletişim</a>
				</li>
				<?php
			if($perm == 1)
			{
			?>
				<li>
					<a href="#adminSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-toggle-sidebar"><i class="fa fa-lock"></i> Yetkili Paneli</a>
					<ul class="collapse list-unstyled" id="adminSubMenu">
						<li>
							<a href="#sessionSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-toggle-sidebar"> Oturum İşlemleri</a>
							<ul class="collapse list-unstyled" id="sessionSubMenu">
								<li>
									<a href="#">Oturum Ekle</a>
								</li>
								<li>
									<a href="#">Oturum Düzenle</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#testSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-toggle-sidebar"> Test İşlemleri</a>
							<ul class="collapse list-unstyled" id="testSubMenu">
								<li>
									<a href="#">Test Ekle</a>
								</li>
								<li>
									<a href="#">Test Düzenle</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#questionSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-toggle-sidebar"> Soru İşlemleri</a>
							<ul class="collapse list-unstyled" id="questionSubMenu">
								<li>
									<a href="#">Soru Ekle</a>
								</li>
								<li>
									<a href="#">Soru Düzenle</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
			<?php
			}
			?>
			</ul>
		</nav>
		<div id="content">
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
				<button type="button" id="sidebarCollapse" class="sidebarbutton">
				<span class="navbar-toggler-icon"></span>
				</button>
				<a class="navbar-brand" href="#">Çevrimiçi Test Sistemi</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarColor01">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active">
					<a class="nav-link" href="#"><i class="fas fa-home"></i> Anasayfa <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href="about.php"><i class="fas fa-info"></i> Hakkında</a>
					</li>
				<?php
				if(IsLoggedIn())
				{
					echo '<span id="loginLi"><em class="navbar-text" id="welcomeText">Hoşgeldiniz, ' . htmlspecialchars($_SESSION['username']) . '</em>
						<li class="nav-item" style="display:inline-block">
						<a class="nav-link" href="#" onclick="logOut();return false;"><i class="fas fa-sign-out-alt"></i><strong> Çıkış Yap</strong></a>
					</li></span>';
				}
				else
				{
					echo '
					<span id="loginLi">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-user-circle"></i> Hesap
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#signUpModal"><i class="fas fa-user"></i> Kayıt Ol</a>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#signInModal"><i class="fas fa-sign-in-alt"></i> Giriş Yap</a>
						</div>
					</li></span>';
				}
				?>
				</ul>
				</div>
			</nav>
		<?php
		$sessionid = intval($_GET['sessionid']);
		if(!IsLoggedIn())
		{
			exit('<div class="alert alert-danger">
				<button type="button" class="close alert-close">&times;</button>
				Giriş yapılmadı.
				</div>');
		}
		$query = "SELECT ID, startTime, untilTime, isActive FROM sessions WHERE ID = ? LIMIT 1";
		if($stmt = $mysqli->prepare($query))
		{
			$stmt->bind_param("i", $sessionid);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0)
			{
				$row = $result->fetch_assoc();
				if(!$row['isActive'])
				{
					$stmt->close();
					$mysqli->close();
					exit('<div class="alert alert-danger">
					<button type="button" class="close alert-close">&times;</button>
					Oturum aktif değil.
				</div>');
				}
				if($row['startTime'] >= time())
				{
					$stmt->close();
					$mysqli->close();
					exit('<div class="alert alert-danger">
					<button type="button" class="close alert-close">&times;</button>
					Oturum henüz başlamadı.
				</div>');
				}
				if($row['untilTime'] <= time())
				{
					$stmt->close();
					$mysqli->close();
					exit('<div class="alert alert-danger">
					<button type="button" class="close alert-close">&times;</button>
					Oturum süresi doldu.
				</div>');
				}
			}
			else
			{
				$stmt->close();
				$mysqli->close();
				exit('<div class="alert alert-danger">
					<button type="button" class="close alert-close">&times;</button>
					Oturum bulunamadı.
				</div>');
			}
		}

		$testid = 0;
		$lastquestionnum = 0;
		$questionnum = (isset($_GET['questionnum']) ? intval($_GET['questionnum']) : $questionnum = 1);
		$query = "SELECT ID, testID, testName, userName, untilTime FROM sessions WHERE ID = ? LIMIT 1";
		if($stmt = $mysqli->prepare($query))
		{
			$stmt->bind_param("i", $sessionid);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0)
			{
				$row = $result->fetch_assoc();
				$testid = intval($row['testID']);
				echo '<div class="card">
						<div class="card-body">
						<p class="card-text">Test adı: ' . htmlspecialchars($row['testName']) . '.
						<br>Öğretmen adı: ' . htmlspecialchars($row['userName']) . '.
						<br>Kalan süre: <span id ="timerID">' . htmlspecialchars($row['untilTime']) . '</span></p>
						</div>
					</div>';
			}
			$stmt->close();
		}
		$query = "SELECT MAX(questionNum) FROM questions WHERE testID = '$testid'";
		$result = $mysqli->query($query);
		if($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$lastquestionnum = $row['MAX(questionNum)'];
		}
		$questioninfo = [];
		$answerinfo = [];
		$questionid = 0;
		$query = "SELECT ID, question, testID, questionNum, optionA, optionB, optionC, optionD FROM questions WHERE testID = ? AND questionNum = ? LIMIT 1";
		if($stmt = $mysqli->prepare($query))
		{
			$stmt->bind_param("ii", $testid, $questionnum);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0)
			{
				$questioninfo = $result->fetch_assoc();
				$questionid = $questioninfo['ID'];
			}
			$stmt->close();
		}
		$userid = intval($_SESSION['ID']);
		$query = "SELECT ID, questionID, userID, testID, answer FROM answers WHERE testID = ? AND questionID = ? AND userID = ?";
		if($stmt = $mysqli->prepare($query))
		{
			$stmt->bind_param("iii", $testid, $questionid, $userid);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0)
			{	
				$answerinfo = $result->fetch_assoc();
			}
		?>
		<div class="container" style="position: relative; max-width: 40rem;" id="buttonDiv">
			<div class="alert alert-danger" style="display:none; max-width: 40rem; margin: auto;" id="errorAnswer">
				<button type="button" class="close alert-close">&times;</button>
				<span id="errorAnswerText"></span>
			</div>
			<div class="alert alert-success" style="display:none; max-width: 40rem; margin: auto;" id="successAnswer">
				<button type="button" class="close alert-close">&times;</button>
				<span id="successAnswerText"></span>
			</div>
			<div class="card bg-light mb-3">
			<div class="card-header" id="questionTitle">Soru <?php echo $questioninfo['questionNum'];?></div>
			<?php
			if($saveType == FALSE)
			{
			?>
			<div class="card-body">
				<h4 class="card-title" id="questionText"><?php echo $questioninfo['question'];?></h4>
					<div class="form-group">
						<div class="custom-control custom-radio">
						<input type="radio" id="radioOption1" name="customRadio" class="custom-control-input" onchange="onOptionChange('radioOption1')" <?php if($answerinfo['answer'] == 1) echo 'checked=""';?>>
						<label class="custom-control-label" for="radioOption1" id="optionText1"><?php echo $questioninfo['optionA'];?></label>
						</div>
						<div class="custom-control custom-radio">
						<input type="radio" id="radioOption2" name="customRadio" class="custom-control-input" onchange="onOptionChange('radioOption2')"<?php if($answerinfo['answer'] == 2) echo 'checked=""';?>>
						<label class="custom-control-label" for="radioOption2" id="optionText2"><?php echo $questioninfo['optionB'];?></label>
						</div>
						<div class="custom-control custom-radio">
						<input type="radio" id="radioOption3" name="customRadio" class="custom-control-input" onchange="onOptionChange('radioOption3')"<?php if($answerinfo['answer'] == 3) echo 'checked=""';?>>
						<label class="custom-control-label" for="radioOption3" id="optionText3"><?php echo $questioninfo['optionC'];?></label>
						</div>
						<div class="custom-control custom-radio">
						<input type="radio" id="radioOption4" name="customRadio" class="custom-control-input" onchange="onOptionChange('radioOption4')"<?php if($answerinfo['answer'] == 4) echo 'checked=""';?>>
						<label class="custom-control-label" for="radioOption4" id="optionText4"><?php echo $questioninfo['optionD'];?></label>
						</div>
					</div>
			</div>
			<?php
			}
			else
			{
			?>
			<div class="card-body">
				<h4 class="card-title" id="questionText"><?php echo $questioninfo['question'];?></h4>
				<form action="/saveanswer.php">
					<div class="form-group">
						<div class="custom-control custom-radio">
						<input type="radio" id="radioOption1" name="customRadio" class="custom-control-input" <?php if($answerinfo['answer'] == 1) echo 'checked=""';?>>
						<label class="custom-control-label" for="radioOption1" id="optionText1"><?php echo $questioninfo['optionA'];?></label>
						</div>
						<div class="custom-control custom-radio">
						<input type="radio" id="radioOption2" name="customRadio" class="custom-control-input" <?php if($answerinfo['answer'] == 2) echo 'checked=""';?>>
						<label class="custom-control-label" for="radioOption2" id="optionText2"><?php echo $questioninfo['optionB'];?></label>
						</div>
						<div class="custom-control custom-radio">
						<input type="radio" id="radioOption3" name="customRadio" class="custom-control-input" <?php if($answerinfo['answer'] == 3) echo 'checked=""';?>>
						<label class="custom-control-label" for="radioOption3" id="optionText3"><?php echo $questioninfo['optionC'];?></label>
						</div>
						<div class="custom-control custom-radio">
						<input type="radio" id="radioOption4" name="customRadio" class="custom-control-input" <?php if($answerinfo['answer'] == 4) echo 'checked=""';?>>
						<label class="custom-control-label" for="radioOption4" id="optionText4"><?php echo $questioninfo['optionD'];?></label>
						</div>
					</div>
				</form>
			</div>
			<?php
			}
			?>
		</div>
		<?php
			if($saveType == FALSE)
			{
				if($questionnum != $lastquestionnum)
				{
					echo '<a class="btn btn-primary" style="position: absolute; left: 200px;" role="button" id="nextButton" href="joinsession.php?sessionid=' . $sessionid . '&questionnum=' . ($questionnum + 1) . '">Sonraki soru ></a>';
				}
				else
				{
					echo '<a class="btn btn-primary" style="position: absolute; left: 200px;" role="button" id="finishButton" href="index.php">Testi bitir </a>';
				}
				if($questionnum > 1)
				{ 
					echo "\r\n" . '<a class="btn btn-primary" style="position: absolute;" role="button" id="prevButton" href="joinsession.php?sessionid=' . $sessionid . '&questionnum=' . ($questionnum - 1) . '">< Önceki soru </a>';
				}
			}
			else
			{
				if($questionnum != $lastquestionnum)
				{
					echo '<a class="btn btn-primary" style="position: absolute; left: 200px;" role="button" id="nextButton" onclick="postAnswer(0)" href ="#">Sonraki soru ></a>';
				}
				else
				{
					echo '<a class="btn btn-primary" style="position: absolute; left: 200px;" role="button" id="finishButton" href="#" onclick="postAnswer(2)">Testi bitir </a>';
				}
				if($questionnum > 1)
				{ 
					echo "\r\n" . '<a class="btn btn-primary" style="position: absolute;" role="button" id="prevButton" onclick="postAnswer(1)" href="#">< Önceki soru </a>';
				}
			}
			$stmt->close();
		}
		$mysqli->close();
		?>
		</div>
		<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="signUpLabel">Kayıt Ol</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger" style="display:none" id="errorModal">
				<button type="button" class="close alert-close">&times;</button>
				<span id="errorModalText"></span>
				</div>
				<div class="alert alert-success" style="display:none" id="successModal">
				<button type="button" class="close alert-close">&times;</button>
				<span id="successModalText"></span>
				</div>
				<div class="form-group">
					<label class="col-form-label" for="userName">Kullanıcı adı:</label>
					<input type="text" class="form-control" placeholder="Kullanıcı adınızı giriniz." id="userName">
					<label for="email">E-posta adresi:</label>
					<input type="email" class="form-control" id="eMail" aria-describedby="emailHelp" placeholder="E-posta adresinizi giriniz.">
					<small id="emailHelp" class="form-text text-muted">E-posta adresiniz kimseyle paylaşılmayacaktır.</small>
				</div>
				<button type="button" class="btn btn-primary" id="signUpButton">Kaydol</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
			</div>
			</div>
		</div>
		</div>
		<div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="signInLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="signInLabel">Giriş Yap</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger" style="display:none" id="errorSignInModal">
				<button type="button" class="close alert-close">&times;</button>
				<span id="errorSignInModalText"></span>
				</div>
				<div class="alert alert-success" style="display:none" id="successSignInModal">
				<button type="button" class="close alert-close">&times;</button>
				<span id="successSignInModalText"></span>
				</div>
				<div class="form-group">
					<label class="col-form-label" for="signInUserName">Kullanıcı adı:</label>
					<input type="text" class="form-control" placeholder="Kullanıcı adınızı giriniz." id="signInUserName">
				</div>
				<button type="button" class="btn btn-primary" id="signInButton">Giriş Yap</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
			</div>
			</div>
		</div>
		</div>
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.3.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script>
	function timerFunc(timerid, countDownDate, isTimer) {
		  // Get todays date and time
		  var now = new Date().getTime();
			
		  // Find the distance between now and the count down date
		  var distance = countDownDate - now;
			
		  // Time calculations for days, hours, minutes and seconds
		  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			
		  // Output the result in an element with id="demo"
		  var timetext = ""; 
		  if(seconds >= 0 && seconds < 10)
		  {
			timetext = "0" + seconds;
		  }
		  else if(seconds > 0 && seconds >= 10)
		  {
			timetext = seconds;
		  }
		  if(minutes > 0 && minutes < 10)
		  {
			timetext = "0" + minutes + ":" + timetext;
		  }
		  else if(minutes > 0 && minutes >= 10)
		  {
			timetext = minutes + ":" + timetext;
		  }
		  else if(minutes == 0)
		  {
			timetext = "00" + ":" + timetext;
		  }
		  if(hours > 0 && hours < 10)
		  {
			timetext = "0" + hours + ":" + timetext;
		  }
		  else if(hours > 0 && hours >= 10)
		  {
			timetext = hours + ":" + timetext;
		  }
		  else if(hours == 0)
		  {
			  timetext = "00" + ":" + timetext;
		  }
		  if(days > 0 && days < 10)
		  {
			timetext = "0" + days + " gün " + timetext;
		  }
		  else if(days > 0 && days >= 10)
		  {
			timetext = days + " gün " + timetext;
	      }
		  document.getElementById(timerid).innerHTML = timetext + ".";
			
		  // If the count down is over, write some text 
		  if (distance < 0) {
			if(isTimer == 1) clearInterval(xtimer);
			document.getElementById(timerid).innerHTML = "Süre doldu.";
		  }
	}
	function checkSession(sessionid)
	{
			$.get("checksession.php", {sessionid: sessionid}, function(data) {
			if(data == "success")
			{
				joinSession(sessionid);
			}
			if(data == "not logged in.")
			{
				$("#error").html("Oturumlara katılmak için giriş yapmalısınız.");
				$("#errorDiv").css('display', 'block');
			}
			if(data == "session is finished.")
			{
				$("#error").html("Oturum sona erdi.");
				$("#errorDiv").css('display', 'block');
			}
			if(data == "session is inactive.")
			{
				$("#error").html("Bu oturum aktif değil.");
				$("#errorDiv").css('display', 'block');
			}
			if(data == "session not found.")
			{
				$("#error").html("Bu oturum bulunamadı.");
				$("#errorDiv").css('display', 'block');
			}
		});
	}
	var xtimer;
	$(document).ready(function(){
		$("#signUpButton").click(function(){
			var name = $("#userName").val();
			var mail = $("#eMail").val();
			$.post("register.php",
			{
			  name: name,
			  mail: mail
			},
			function(data,status){
				$("#successModal").css('display', 'none');
				$("#errorModal").css('display', 'none');
				if(data == "success."){
					$("#successModalText").html("İsminiz başarıyla kaydedildi.");
					$("#successModal").css('display', 'block');
					onUserLogIn(name);
				}
				else if(data == "username already taken."){
					$("#errorModalText").html("Bu isim zaten kayıtlıdır.");
					$("#errorModal").css('display', 'block');
				}
				else if(data == "username is empty."){
					$("#errorModalText").html("Bir isim girmediniz.");
					$("#errorModal").css('display', 'block');
				}
				else if(data == "username is too long.")
				{
					$("#errorModalText").html("Kullanıcı adı 32 karakterden uzun olamaz.");
					$("#errorModal").css('display', 'block');
				}
				else if(data == "email address is empty.")
				{
					$("#errorModalText").html("E-posta adresi boş olamaz.");
					$("#errorModal").css('display', 'block');
				}
				else if(data == "email address is too long.")
				{
					$("#errorModalText").html("E-posta adresi 320 karakterden uzun olamaz.");
					$("#errorModal").css('display', 'block');
				}
				else if(data == "already logged in.")
				{
					$("#errorModalText").html("Zaten giriş yapmışsınız.");
					$("#errorModal").css('display', 'block');
				}
				else
				{
					$("#errorModal").html("Bilinmeyen bir hata oluştu.");
					$("#errorModal").css('display', 'block');
				}
			});
		});
		$("#signInButton").click(function(){
			var name = $("#signInUserName").val();
			$.post("login.php",
			{
			  name: name
			},
			function(data,status){
				$("#successSignInModal").css('display', 'none');
				$("#errorSignInModal").css('display', 'none');
				if(data == "success.")
				{
					$("#successSignInModalText").html("Başarıyla giriş yaptınız.");
					$("#successSignInModal").css('display', 'block');
					onUserLogIn(name);
				}
				else if(data == "already logged in.")
				{
					$("#errorSignInModalText").html("Zaten giriş yapmışsınız.");
					$("#errorSignInModal").css('display', 'block');
				}
				else if(data == "username is too long.")
				{
					$("#errorSignInModalText").html("Kullanıcı adı 32 karakterden uzun olamaz.");
					$("#errorSignInModal").css('display', 'block');
				}
				else if(data == "username is empty.")
				{
					$("#errorSignInModalText").html("Kullanıcı adı boş olamaz.");
					$("#errorSignInModal").css('display', 'block');
				}
				else if(data == "user not found.")
				{
					$("#errorSignInModalText").html("Kullanıcı bulunamadı.");
					$("#errorSignInModal").css('display', 'block');
				}
				else
				{
					$("#errorSignInModalText").html("Bilinmeyen bir hata oluştu.");
					$("#errorSignInModal").css('display', 'block');
				}
			});
		});
		$("#signInUserName").keypress(function(event){
			if(event.which == 13)
			{
				$("#signInButton").click();
			}
		});
		$("#userName, #eMail").keypress(function(){
			if(event.which == 13)
			{
				$("#signUpButton").click();
			}
		});
		$('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
        });
		var countDownDate = parseInt(document.getElementById("timerID").innerHTML) * 1000;
		timerFunc("timerID", countDownDate, 0);
		xtimer = setInterval(function(){timerFunc("timerID", countDownDate, 1);}, 1000);
	});
	$(function() {
	   $(document).on('click', '.alert-close', function() {
		   $(this).parent().hide();
	   })
	});
	function logOut()
	{
		$.get("logout.php", function(data, status)
		{
			if(status == "success")
			{
				onUserLogOut();
			}
		});
	}
	function onUserLogIn(name)
	{
		$("#loginLi").html('<em class="navbar-text" id="welcomeText">Hoşgeldiniz, ' + name + '</em>' +
				'<li class="nav-item" style="display:inline-block">' +
				'<a class="nav-link" href="#" onclick="logOut();return false;"><i class="fas fa-sign-out-alt"></i><strong> Çıkış Yap</strong></a>' +
			'</li>');
		setTimeout(function(){hideSignModals();}, 750);
	}
	function hideSignModals()
	{
		if ($('#signInModal').is(':visible'))
		{
			$('#signInModal').modal('hide');
		}
		if ($('#signUpModal').is(':visible'))
		{
			$('#signUpModal').modal('hide');
		}
	}
	function onUserLogIn(name)
	{
		$("#loginLi").html('<em class="navbar-text" id="welcomeText">Hoşgeldiniz, ' + name + '</em>' +
				'<li class="nav-item" style="display:inline-block">' +
				'<a class="nav-link" href="#" onclick="logOut();return false;"><i class="fas fa-sign-out-alt"></i><strong> Çıkış Yap</strong></a>' +
			'</li>');
		setTimeout(function(){hideSignModals();}, 750);
	}
	function onUserLogOut()
	{
		$("#loginLi").html(`<span id="loginLi">
					<li class="nav-item dropdown">
					  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-user-circle"></i> Hesap
					  </a>
					  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#signUpModal"><i class="fas fa-user"></i> Kayıt Ol</a>
						  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#signInModal"><i class="fas fa-sign-in-alt"></i> Giriş Yap</a>
					  </div>
					</li></span>`);
	}
	$('#signInModal').on('show.bs.modal', function (event) {
		$("#successSignInModal").css('display', 'none');
		$("#errorSignInModal").css('display', 'none');
	});
	$('#signUpModal').on('show.bs.modal', function (event) {
		$("#successModal").css('display', 'none');
		$("#errorModal").css('display', 'none');
	});
	function onOptionChange(optionid)
	{
		var sessionid = <?php echo $sessionid; ?>;
		var testid = <?php echo $testid; ?>;
		var questionid = <?php echo $questionid; ?>;
		var optionnum = 0;
		switch(optionid)
		{
			case "radioOption1":
			{
				optionnum = 1;
				break;
			}
			case "radioOption2":
			{
				optionnum = 2;
				break;
			}
			case "radioOption3":
			{
				optionnum = 3;
				break;
			}
			case "radioOption4":
			{
				optionnum = 4;
			}
		}
		$.post("saveanswer.php",
		{
			sessionid: sessionid,
			testid: testid,
			questionid: questionid,
			optionid: optionnum
		},
		function(data,status){
			$("#successAnswer").css('display', 'none');
			$("#errorAnswer").css('display', 'none');
			if(data == "correct answer.")
			{
				$("#successAnswerText").html("Soruyu doğru cevapladınız, tebrikler.");
				$("#successAnswer").css('display', 'block');
			}
			else if(data == "no data.")
			{
				$("#errorAnswerText").html("Veri yok.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "not logged in.")
			{
				$("#errorAnswerText").html("Giriş yapılmamış.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "session is inactive.")
			{
				$("#errorAnswerText").html("Oturum devre dışı.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "session is finished.")
			{
				$("#errorAnswerText").html("Süre doldu.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "session not found.")
			{
				$("#errorAnswerText").html("Oturum bulunamadı.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "already answered.")
			{
				$("#errorAnswerText").html("Soruyu daha önce cevapladınız.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "saving error.")
			{
				$("#errorAnswerText").html("Soruyu kaydederken bir hata oluştu.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data.indexOf("it is") != -1)
			{
				var cAnswerText = "";
				switch(data)
				{
					case "it is A.":
					{
						cAnswerText = "A";
						break;
					}
					case "it is B.":
					{
						cAnswerText = "B";
						break;
					}
					case "it is C.":
					{
						cAnswerText = "C";
						break;
					}
					case "it is D.":
					{
						cAnswerText = "D";
						break;
					}
				}
				$("#errorAnswerText").html("Soruyu yanlış cevapladınız. Doğru cevap: " + cAnswerText + ".");
				$("#errorAnswer").css('display', 'block');
			}
			else
			{
				$("#errorAnswerText").html("Bilinmeyen bir hata oluştu.");
				$("#errorAnswer").css('display', 'block');
			}
		});
	}
	function postAnswer(position)
	{
		var sessionid = <?php echo $sessionid; ?>;
		var testid = <?php echo $testid; ?>;
		var questionid = <?php echo $questionid; ?>;
		var optionnum = $('input[type=radio][name=customRadio]:checked').attr('id');
		switch(optionnum)
		{
			case "radioOption1":
			{
				optionnum = 1;
				break;
			}
			case "radioOption2":
			{
				optionnum = 2;
				break;
			}
			case "radioOption3":
			{
				optionnum = 3;
				break;
			}
			case "radioOption4":
			{
				optionnum = 4;
			}
		}
		$.post("saveanswer.php",
		{
			sessionid: sessionid,
			testid: testid,
			questionid: questionid,
			optionid: optionnum
		},
		function(data,status){
			$("#successAnswer").css('display', 'none');
			$("#errorAnswer").css('display', 'none');
			if(data == "no data.")
			{
				$("#errorAnswerText").html("Veri yok.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "not logged in.")
			{
				$("#errorAnswerText").html("Giriş yapılmamış.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "session is inactive.")
			{
				$("#errorAnswerText").html("Oturum devre dışı.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "session is finished.")
			{
				$("#errorAnswerText").html("Süre doldu.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "session not found.")
			{
				$("#errorAnswerText").html("Oturum bulunamadı.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "saving error.")
			{
				$("#errorAnswerText").html("Soruyu kaydederken bir hata oluştu.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "failure.")
			{
				$("#errorAnswerText").html("Soruyu kaydederken bir hata oluştu.");
				$("#errorAnswer").css('display', 'block');
			}
			else if(data == "success.")
			{
				if(position == 0) //sonraki soruya giderse
				{
					window.location.href = "joinsession.php?sessionid=<?php echo $sessionid; ?>&questionnum=<?php echo $questionnum + 1; ?>";
				}
				else if(position == 1) //önceki soru
				{
					window.location.href = "joinsession.php?sessionid=<?php echo $sessionid; ?>&questionnum=<?php echo $questionnum - 1; ?>";
				}
				else if(position == 2)
				{
					window.location.href = "index.php";
				}
			}
			else
			{
				$("#errorAnswerText").html("Bilinmeyen bir hata oluştu.");
				$("#errorAnswer").css('display', 'block');
			}
		});
	}
	</script>
  </body>
</html>