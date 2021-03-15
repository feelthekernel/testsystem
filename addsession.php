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
			<div class="alert alert-success" style="display:none; margin: auto;" id="successAnswer">
				<button type="button" class="close alert-close">&times;</button>
				<span id="successAnswerText"></span>
			</div>
			<?php
				if(!IsLoggedIn() || $perm != 1)
				{
					echo('<script>$("#errorAnswerText").html("Giriş yapmadınız veya yetkiniz yetersiz."); $("#errorAnswer").css("display", "block");</script>');
					exit();
				}
			?>
			<center><h1>Oturum Ekle</h1></center>
			<?php
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$sessionName = $_POST['sessionName'];
				sscanf($_POST['testID'], "%d %s", $testID, $testName);
				$startTime = $_POST['time1'];
				$endTime = $_POST['time2'];
				$lenSessionName = strlen($sessionName);
				$userID = intval($_SESSION['ID']);
				$userName = $_SESSION['username'];
				if(empty($sessionName))
				{
					echo('<script>$("#errorAnswerText").html("Oturum ismi girmediniz."); $("#errorAnswer").css("display", "block");</script>');
				}
				else if($lenSessionName < 3 || $lenSessionName > 32)
				{
					echo('<script>$("#errorAnswerText").html("Oturum ismi 3 ile 32 karakter arasında olmalıdır."); $("#errorAnswer").css("display", "block");</script>');
				}
				else if(empty($testID))
				{
					echo('<script>$("#errorAnswerText").html("Test seçmediniz."); $("#errorAnswer").css("display", "block");</script>');
				}
				else if(empty($startTime))
				{
					echo('<script>$("#errorAnswerText").html("Başlangıç zamanı seçmediniz."); $("#errorAnswer").css("display", "block");</script>');
				}
				else if(empty($endTime))
				{
					echo('<script>$("#errorAnswerText").html("Bitiş zamanı seçmediniz."); $("#errorAnswer").css("display", "block");</script>');
				}
				else if(sscanf($startTime, "%d.%d.%d %d:%d", $startDay, $startMonth, $startYear, $startHour, $startMin))
				{
					if(sscanf($endTime, "%d.%d.%d %d:%d", $endDay, $endMonth, $endYear, $endHour, $endMin))
					{
						$startTimeFull = sprintf("%d-%d-%d %d:%d:00", $startYear, $startMonth, $startDay, $startHour, $startMin);
						$endTimeFull = sprintf("%d-%d-%d %d:%d:00", $endYear, $endMonth, $endDay, $endHour, $endMin);

						$startTimeStamp = strtotime($startTimeFull);
						$endTimeStamp = strtotime($endTimeFull);
					
						$currentTimeStamp = time();

						if($startTimeStamp > $currentTimeStamp)
						{
							if($endTimeStamp > $currentTimeStamp)
							{
								if($endTimeStamp > $startTimeStamp)
								{
									$query = "INSERT INTO sessions (name, testID, testName, userID, userName, time, startTime, untilTime, isActive) VALUES (?, ?, ?, ?, ?, UNIX_TIMESTAMP(), ?, ?, 1)";
									if($stmt = $mysqli->prepare($query))
									{
										$stmt->bind_param("sisisii", $sessionName, $testID, $testName, $userID, $userName, $startTimeStamp, $endTimeStamp);
										if($stmt->execute())
										{
											echo('<script>$("#successAnswerText").html("Oturum başarıyla oluşturuldu."); $("#successAnswer").css("display", "block");</script>');
											$stmt->close();
											$mysqli->close();
										}
										else
										{
											$stmt->close();
											$mysqli->close();
											echo('<script>$("#errorAnswerText").html("Kaydederken sorun oluştu."); $("#errorAnswer").css("display", "block");</script>');
											exit("saving error.");
										}
									}
								}
								else
								{
									echo('<script>$("#errorAnswerText").html("Bitiş zamanı başlangıç zamanından önce olamaz."); $("#errorAnswer").css("display", "block");</script>');
								}
							}
							else
							{
								echo('<script>$("#errorAnswerText").html("Bitiş zamanı şu anki zamandan daha önce olamaz."); $("#errorAnswer").css("display", "block");</script>');
							}
						}
						else
						{
							echo('<script>$("#errorAnswerText").html("Başlangıç zamanı şu anki zamandan daha önce olamaz."); $("#errorAnswer").css("display", "block");</script>');
						}
					}
					else
					{
						echo('<script>$("#errorAnswerText").html("Bitiş zamanını yanlış girdiniz."); $("#errorAnswer").css("display", "block");</script>');
					}
				}
				else
				{
					echo('<script>$("#errorAnswerText").html("Başlangıç zamanını yanlış girdiniz."); $("#errorAnswer").css("display", "block");</script>');
				}
			}
			?>
            <form action="addsession.php" method="POST">
                <div class="form-group">
                    <label for="sessionName">Oturum Adı:</label>
                    <input type="text" class="form-control" id="sessionName" name="sessionName" maxlength="32" aria-describedby="sessionNameHelp" placeholder="Oturum adını giriniz.">
                    <small id="sessionNameHelp" class="form-text text-muted">Oturum adını giriniz ("İlk sınav" gibi).</small>
                </div>
                <div class="form-group">
                    <label for="testName">Test Seçiniz:</label>
                    <select class="form-control" id="testName" name="testID">
                <?php
                    $query = "SELECT ID, name, userID, userName FROM tests";
                    if($stmt = $mysqli->prepare($query))
                    {
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if($result->num_rows > 0)
                        {
                            while($row = $result->fetch_assoc())
                            {
                                echo('<option value="' . $row['ID'] . ' ' . $row['name'] . '">' . $row['name'] . '</option>' . PHP_EOL);
                            }

                        }
                        else
                        {
							echo('<script>$("#errorAnswerText").html("Test bulunamadı."); $("#errorAnswer").css("display", "block");</script>');
                        }
                    }
                ?>
                    </select>
                </div>
				<div class="form-group">
                    <label for="time1">Başlangıç Zamanı:</label>
                    <input type="text" class="form-control" id="time1" name="time1" maxlength="32" aria-describedby="time1Help" autocomplete="off" placeholder="Başlangıç zamanını seçiniz.">
                    <small id="time1Help" class="form-text text-muted">Oturumun başlayacağı tarih ve saati seçiniz.</small>
                </div>
				<div class="form-group">
                    <label for="time2">Bitiş Zamanı:</label>
                    <input type="text" class="form-control" id="time2" name="time2" aria-describedby="time2Help" autocomplete="off" placeholder="Bitiş zamanını seçiniz.">
                    <small id="time2Help" class="form-text text-muted">Oturumun sona ereceği tarih ve saati seçiniz.</small>
                </div>
                <button type="submit" class="btn btn-primary">Ekle</button>
            </form>
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