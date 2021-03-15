<!doctype html>
<?php
	require_once('connect.php');
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
	<link href="css/all.css" rel="stylesheet">

    <title>Test Script</title>
  </head>
  <body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <a class="navbar-brand" href="#">ELT Test System</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarColor01">
		<ul class="navbar-nav mr-auto">
		  <li class="nav-item">
			<a class="nav-link" href="index.php">Anasayfa <span class="sr-only">(current)</span></a>
		  </li>
		  <li class="nav-item" id="navSession">
			<a class="nav-link" href="sessions.php">Oturum Listesi</a>
		  </li>
		  <?php
			if(IsLoggedIn())
			{
				echo '<li class="nav-item active" id="navPastSessions">
			<a class="nav-link" href="#">Geçmiş Oturumlar</a>
		  </li>';
			}
		  ?>
		  <li class="nav-item">
			<a class="nav-link" href="about.php">Hakkında</a>
		  </li>
		</ul>
	  </div>
	  <?php
		if(IsLoggedIn())
		{
			echo '<ul class="nav navbar-nav navbar-right" id="regId">
				<span class="navbar-text">Hoşgeldiniz, ' . htmlspecialchars($_SESSION['username']) . '</span>
				<li class="nav-item">
				<a class="nav-link" href="#" onclick="logOut();return false;"><i class="fas fa-sign-out-alt"></i><strong> Çıkış Yap</strong></a>
			</li>';
		}
		else
		{
			echo '<ul class="nav navbar-nav navbar-right" id="regId">
			<li class="nav-item">
				<a class="nav-link" href="#" data-toggle="modal" data-target="#signUpModal"><i class="fas fa-user"></i> Kayıt Ol</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#" data-toggle="modal" data-target="#signInModal"><i class="fas fa-sign-in-alt"></i> Giriş Yap</a>
			</li>
		</ul>';
		}
	  ?>
	</nav>
	<?php
	if(!IsLoggedIn())
	{
		echo '<div class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Hata!</strong> Sayfayı görebilmek için giriş yapmalısınız.</div>';
		exit();
	}
	?>
	<div class="jumbotron">
		<center><h1>Yapım Aşaması</h1>
		<p>Bu sayfa henüz yapım aşamasındadır.</p></center> 
	</div> 
	<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Kayıt Ol</h5>
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
				<button type="button" class="btn btn-primary" id="signUpButton">Kaydol</button>
			</div>
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
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.3.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script>
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
	function onUserLogOut()
	{
		$("#regId").html("<li class=\"nav-item\"><a class=\"nav-link\" href=\"#\" data-toggle=\"modal\" data-target=\"#signUpModal\"><i class=\"fas fa-user\"></i> Kayıt Ol</a></li>" + 
		"<li class=\"nav-item\"><a class=\"nav-link\" href=\"#\" data-toggle=\"modal\" data-target=\"#signInModal\"><i class=\"fas fa-sign-in-alt\"></i> Giriş Yap</a>");
		$("#navPastSessions").remove();
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