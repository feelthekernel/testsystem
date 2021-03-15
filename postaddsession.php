<!doctype html>
<?php
	require_once('connect.php');
	if(isset($_SESSION['perm']))
	{
		$perm = $_SESSION['perm'];
	}
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

	<!-- Date-Time Picker CSS -->
	<link rel="stylesheet" type="text/css" href="jquery.datetimepicker.min.css">

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="jquery-3.3.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	<!-- Date-Time Picker JS -->
	<script src="jquery.datetimepicker.full.js"></script>


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
								<a href="addsession.php">Oturum Ekle</a>
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
			<div class="alert alert-danger" style="display:none; margin: auto;" id="errorAnswer">
				<button type="button" class="close alert-close">&times;</button>
				<span id="errorAnswerText"></span>
			</div>
			<?php
				if(!IsLoggedIn() || $perm != 1)
				{
					echo('<script>$("#errorAnswerText").html("Giriş yapmadınız veya yetkiniz yetersiz."); $("#errorAnswer").css("display", "block");</script>');
					exit();
                }
                if($_SERVER['REQUEST_METHOD'] != 'POST')
                {
                    echo('<script>$("#errorAnswerText").html("Veriler yetersiz."); $("#errorAnswer").css("display", "block");</script>');
					exit();
                }
                
			?>
			<center><h1>Oturum Ekle</h1></center>
            
		</div>
	</div>
	<!-- Optional JavaScript -->
	<script>
	jQuery.datetimepicker.setLocale('tr');
	jQuery('#time1').datetimepicker({
		format:'d.m.Y H:i'
	});
	jQuery('#time2').datetimepicker({
		format:'d.m.Y H:i'
	});
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