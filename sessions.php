﻿<!doctype html>
<?php
	require_once('connect.php');
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
				<li class="active">
					<a href="#"><i class="fas fa-list"></i> Oturum Listesi</a>
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
				  <li class="nav-item">
					<a class="nav-link" href="index.php"><i class="fas fa-home"></i> Anasayfa <span class="sr-only">(current)</span></a>
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
			<div class="card">
			  <div class="card-body">
				<h4 class="card-title">Oturum Listesi</h4>
				<p class="card-text">Buradan aktif oturumlara katılarak soruları cevaplamaya başlayabilirsiniz.</p>
			  </div>
			</div>
			<div class="alert alert-danger" style="display:none" id="errorDiv">
			  <button type="button" class="close alert-close">&times;</button>
			  <span id="error"></span>
			</div>
			<div class="table-responsive">
				<table class="table table-hover">
				  <thead>
					<tr>
					  <th scope="col">#</th>
					  <th scope="col">Test İsmi</th>
					  <th scope="col">Öğretmen</th>
					  <th scope="col">Başlama Zamanı</th>
					  <th scope="col">Kalan Süre</th>
					  <th scope="col"></th>
					</tr>
				  </thead>
				  <tbody>
					<?php
					$query = "SELECT ID, testName, userName, startTime, untilTime, isActive FROM sessions WHERE isActive = 1";
					$result = $mysqli->query($query);
					if($result->num_rows > 0)
					{
						$i = 0;
						while($row = $result->fetch_assoc())
						{
							$i++;
							$startDate = date("d.m.Y H:i", $row['startTime']);
							echo "<tr>
									<th scope=\"row\">$i</th>
									<td>{$row['testName']}</td>
									<td>{$row['userName']}</td>
									<td>{$startDate}</td>
									<td><span id=\"timer$i\" style=\"display:none\">{$row['untilTime']}</span></td>
									<td><button type=\"button\" onclick=\"checkSession({$row['ID']})\" class=\"btn btn-success\">KATIL</button></td>
									</tr>";
						}
						echo "<span id=\"lastid\" style=\"display:none\">$i</span>";
						$mysqli->close();
					}
					?>
				  </tbody>
				</table>
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
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.3.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script>
	function startTimer (timerid)
	{
		// Set the date we're counting down to
		var countDownDate = parseInt(document.getElementById(timerid).innerHTML) * 1000;
		
		var showit = 0;
		// Update the count down every 1 second
		var x = setInterval(function() {
		  if(!showit) document.getElementById(timerid).style.display = "", showit = 1;
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
			timetext = days + " gün " + timetext;
		  }
		  else if(days > 0 && days >= 10)
		  {
			timetext = days + " gün " + timetext;
	      }
		  document.getElementById(timerid).innerHTML = timetext;
			
		  // If the count down is over, write some text 
		  if (distance < 0) {
			clearInterval(x);
			document.getElementById(timerid).innerHTML = "Süre doldu.";
		  }
		}, 1000);
	}
	$(document).ready(function(){
		var lastid = parseInt(document.getElementById("lastid").innerHTML);
		for(var i = 1; i <= lastid; i ++)
		{
			startTimer("timer" + i);
		}
	});
	function checkSession(sessionid)
	{
			$.get("checksession.php", {sessionid: sessionid}, function(data) {
			if(data == "success")
			{
				joinSession(sessionid);
			}
			else if(data == "not logged in.")
			{
				$("#error").html("Oturumlara katılmak için giriş yapmalısınız.");
				$("#errorDiv").css('display', 'block');
			}
			else if(data == "session is finished.")
			{
				$("#error").html("Oturum sona erdi.");
				$("#errorDiv").css('display', 'block');
			}
			else if(data == "session is inactive.")
			{
				$("#error").html("Bu oturum aktif değil.");
				$("#errorDiv").css('display', 'block');
			}
			else if(data == "session is not started.")
			{
				$("#error").html("Bu oturum henüz başlamadı.");
				$("#errorDiv").css('display', 'block');
			}
			else if(data == "session not found.")
			{
				$("#error").html("Bu oturum bulunamadı.");
				$("#errorDiv").css('display', 'block');
			}
		});
	}
	function joinSession(sessionid)
	{
		window.location.href = 'joinsession.php?sessionid=' + sessionid;
	}
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
	$('#signInModal').on('show.bs.modal', function (event) {
		$("#successSignInModal").css('display', 'none');
		$("#errorSignInModal").css('display', 'none');
	});
	$('#signUpModal').on('show.bs.modal', function (event) {
		$("#successModal").css('display', 'none');
		$("#errorModal").css('display', 'none');
	});
	</script>
  </body>
</html>