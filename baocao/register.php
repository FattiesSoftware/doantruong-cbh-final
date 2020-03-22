<?php// Change this to your connection info.$DATABASE_HOST = 'localhost';$DATABASE_USER = 'root';$DATABASE_PASS = '';$DATABASE_NAME = 'members';// Try and connect using the info above.$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);if (mysqli_connect_errno()) {	// If there is an error with the connection, stop the script and display the error.	die ('Failed to connect to MySQL: ' . mysqli_connect_error()) ;}// Now we check if the data was submitted, isset() function will check if the data exists.if (!isset($_POST['name'], $_POST['username'], $_POST['password'], $_POST['email'])) {	// Could not get the data that should have been sent.	die ('Please complete the registration form!') ;}// Make sure the submitted registration values are not empty.if (empty($_POST['name']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {	// One or more values are empty.	die ('Please complete the registration form') 	;}if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {	die ('Email is not valid!') ;}if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {    die ('Username is not valid!') ;}if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {	die ('Password must be between 5 and 20 characters long!');}	$name = $_POST['name'];// We need to check if the account with that username exists.if ($stmt = $con->prepare('SELECT id,  password FROM accounts WHERE  username = ? ')) {	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.	$stmt->bind_param('s', $_POST['username']);	$stmt->execute();	$stmt->store_result();	// Store the result so we can check if the account exists in the database.	if ($stmt->num_rows > 0) {		// Username already exists		$message = 'Username exists, please choose another!';	} else {// Username doesnt exists, insert new accountif ($stmt = $con->prepare('INSERT INTO accounts (name, username, password, email) VALUES (?, ?, ?, ?)')) {	// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.	$name = $_POST['name'];	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);	$stmt->bind_param('ssss', $_POST['name'], $_POST['username'], $password, $_POST['email']);	$stmt->execute();	$message = 'You have successfully registered, you can now login!';} else {	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.	$message = 'Could not prepare statement!';}	}	$stmt->close();} else {	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.	$message = 'Could not prepare statement!';}$con->close();?><!DOCTYPE html><html>  <!-- Trang web được lập trình bởi Dương Tùng Anh - C4K60 Chuyên Hà Nam --><!-- Mọi thông tin chi tiết xin liên hệ https://facebook.com/tunnaduong/ -->	<!DOCTYPE html><title>Login V2</title>	<meta charset="UTF-8">	<meta name="viewport" content="width=device-width, initial-scale=1"><!--===============================================================================================-->		<link rel="icon" type="image/png" href="images/icons/favicon.ico"/><!--===============================================================================================-->	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css"><!--===============================================================================================-->	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css"><!--===============================================================================================-->	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css"><!--===============================================================================================-->	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css"><!--===============================================================================================-->		<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css"><!--===============================================================================================-->	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css"><!--===============================================================================================-->	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css"><!--===============================================================================================-->		<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css"><!--===============================================================================================-->	<link rel="stylesheet" type="text/css" href="css/util.css">	<link rel="stylesheet" type="text/css" href="css/main.css"><!--===============================================================================================--><!-- Latest compiled JavaScript --><script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script><link crossorigin='anonymous' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css' integrity='sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/' rel='stylesheet'/></head>  <body data-spy="scroll" data-target=".navbar" data-offset="50">      <script>          var attempt = 3; // Variable to count number of attempts.// Below function Executes on click of login button.function validate(){var password = document.getElementById("form-password").value;if ( password == "ilovecbh123"){alert ("Đăng nhập thành công!");window.location = "welcome.php"; // Redirecting to other page.return false;}else{attempt --;// Decrementing by one.alert("Bạn còn "+attempt+" lượt đăng nhập;");// Disabling fields after 3 attempts.if( attempt == 0){document.getElementById("form-username").disabled = true;document.getElementById("form-password").disabled = true;document.getElementById("submit").disabled = true;return false;}}}          </script>          <style>/*//////////////////////////////////////////////////////////////////[ FONT ]*/@font-face {  font-family: Poppins-Regular;  src: url('../fonts/poppins/Poppins-Regular.ttf'); }@font-face {  font-family: Poppins-Medium;  src: url('../fonts/poppins/Poppins-Medium.ttf'); }@font-face {  font-family: Poppins-Bold;  src: url('../fonts/poppins/Poppins-Bold.ttf'); }@font-face {  font-family: Poppins-SemiBold;  src: url('../fonts/poppins/Poppins-SemiBold.ttf'); }/*//////////////////////////////////////////////////////////////////[ RESTYLE TAG ]*/* {	margin: 0px; 	padding: 0px; 	box-sizing: border-box;}body, html {	height: 100%;	font-family: Poppins-Regular, sans-serif;}/*---------------------------------------------*/a {	font-family: Poppins-Regular;	font-size: 14px;	line-height: 1.7;	color: #666666;	margin: 0px;	transition: all 0.4s;	-webkit-transition: all 0.4s;  -o-transition: all 0.4s;  -moz-transition: all 0.4s;}a:focus {	outline: none !important;}a:hover {	text-decoration: none;  color: #6a7dfe;  color: -webkit-linear-gradient(left, #21d4fd, #b721ff);  color: -o-linear-gradient(left, #21d4fd, #b721ff);  color: -moz-linear-gradient(left, #21d4fd, #b721ff);  color: linear-gradient(left, #21d4fd, #b721ff);}/*---------------------------------------------*/h1,h2,h3,h4,h5,h6 {	margin: 0px;}p {	font-family: Poppins-Regular;	font-size: 14px;	line-height: 1.7;	color: #666666;	margin: 0px;}ul, li {	margin: 0px;	list-style-type: none;}/*---------------------------------------------*/input {	outline: none;	border: none;}textarea {  outline: none;  border: none;}textarea:focus, input:focus {  border-color: transparent !important;}input:focus::-webkit-input-placeholder { color:transparent; }input:focus:-moz-placeholder { color:transparent; }input:focus::-moz-placeholder { color:transparent; }input:focus:-ms-input-placeholder { color:transparent; }textarea:focus::-webkit-input-placeholder { color:transparent; }textarea:focus:-moz-placeholder { color:transparent; }textarea:focus::-moz-placeholder { color:transparent; }textarea:focus:-ms-input-placeholder { color:transparent; }input::-webkit-input-placeholder { color: #adadad;}input:-moz-placeholder { color: #adadad;}input::-moz-placeholder { color: #adadad;}input:-ms-input-placeholder { color: #adadad;}textarea::-webkit-input-placeholder { color: #adadad;}textarea:-moz-placeholder { color: #adadad;}textarea::-moz-placeholder { color: #adadad;}textarea:-ms-input-placeholder { color: #adadad;}/*---------------------------------------------*/button {	outline: none !important;	border: none;	background: transparent;}button:hover {	cursor: pointer;}iframe {	border: none !important;}/*//////////////////////////////////////////////////////////////////[ Utility ]*/.txt1 {  font-family: Poppins-Regular;  font-size: 13px;  color: #666666;  line-height: 1.5;}.txt2 {  font-family: Poppins-Regular;  font-size: 13px;  color: #333333;  line-height: 1.5;}/*//////////////////////////////////////////////////////////////////[ login ]*/.limiter {  width: 100%;  margin: 0 auto;}.container-login100 {  width: 100%;    min-height: 100vh;  display: -webkit-box;  display: -webkit-flex;  display: -moz-box;  display: -ms-flexbox;  display: flex;  flex-wrap: wrap;  justify-content: center;  align-items: center;  padding: 15px;  background: #f2f2f2;  }.wrap-login100 {  width: 390px;  background: #fff;  border-radius: 10px;  overflow: hidden;  padding: 77px 55px 33px 55px;  box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);  -moz-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);  -webkit-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);  -o-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);  -ms-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);}/*------------------------------------------------------------------[ Form ]*/.login100-form {  width: 100%;}.login100-form-title {  display: block;  font-family: Poppins-Bold;  font-size: 30px;  color: #333333;  line-height: 1.2;  text-align: center;}.login100-form-title i {  font-size: 60px;}/*------------------------------------------------------------------[ Input ]*/.wrap-input100 {  width: 100%;  position: relative;  border-bottom: 2px solid #adadad;  margin-bottom: 37px;}.input100 {  font-family: Poppins-Regular;  font-size: 15px;  color: #555555;  line-height: 1.2;  display: block;  width: 100%;  height: 45px;  background: transparent;  padding: 0 5px;}/*---------------------------------------------*/ .focus-input100 {  position: absolute;  display: block;  width: 100%;  height: 100%;  top: 0;  left: 0;  pointer-events: none;}.focus-input100::before {  content: "";  display: block;  position: absolute;  bottom: -2px;  left: 0;  width: 0;  height: 2px;  -webkit-transition: all 0.4s;  -o-transition: all 0.4s;  -moz-transition: all 0.4s;  transition: all 0.4s;  background: #6a7dfe;  background: -webkit-linear-gradient(left, #21d4fd, #b721ff);  background: -o-linear-gradient(left, #21d4fd, #b721ff);  background: -moz-linear-gradient(left, #21d4fd, #b721ff);  background: linear-gradient(left, #21d4fd, #b721ff);}.focus-input100::after {  font-family: Poppins-Regular;  font-size: 15px;  color: #999999;  line-height: 1.2;  content: attr(data-placeholder);  display: block;  width: 100%;  position: absolute;  top: 16px;  left: 0px;  padding-left: 5px;  -webkit-transition: all 0.4s;  -o-transition: all 0.4s;  -moz-transition: all 0.4s;  transition: all 0.4s;}.input100:focus + .focus-input100::after {  top: -15px;}.input100:focus + .focus-input100::before {  width: 100%;}.has-val.input100 + .focus-input100::after {  top: -15px;}.has-val.input100 + .focus-input100::before {  width: 100%;}/*---------------------------------------------*/.btn-show-pass {  font-size: 15px;  color: #999999;  display: -webkit-box;  display: -webkit-flex;  display: -moz-box;  display: -ms-flexbox;  display: flex;  align-items: center;  position: absolute;  height: 100%;  top: 0;  right: 0;  padding-right: 5px;  cursor: pointer;  -webkit-transition: all 0.4s;  -o-transition: all 0.4s;  -moz-transition: all 0.4s;  transition: all 0.4s;}.btn-show-pass:hover {  color: #6a7dfe;  color: -webkit-linear-gradient(left, #21d4fd, #b721ff);  color: -o-linear-gradient(left, #21d4fd, #b721ff);  color: -moz-linear-gradient(left, #21d4fd, #b721ff);  color: linear-gradient(left, #21d4fd, #b721ff);}.btn-show-pass.active {  color: #6a7dfe;  color: -webkit-linear-gradient(left, #21d4fd, #b721ff);  color: -o-linear-gradient(left, #21d4fd, #b721ff);  color: -moz-linear-gradient(left, #21d4fd, #b721ff);  color: linear-gradient(left, #21d4fd, #b721ff);}/*------------------------------------------------------------------[ Button ]*/.container-login100-form-btn {  display: -webkit-box;  display: -webkit-flex;  display: -moz-box;  display: -ms-flexbox;  display: flex;  flex-wrap: wrap;  justify-content: center;  padding-top: 13px;}.wrap-login100-form-btn {  width: 100%;  display: block;  position: relative;  z-index: 1;  border-radius: 25px;  overflow: hidden;  margin: 0 auto;}.login100-form-bgbtn {  position: absolute;  z-index: -1;  width: 300%;  height: 100%;  background: #a64bf4;  background: -webkit-linear-gradient(right, #21d4fd, #b721ff, #21d4fd, #b721ff);  background: -o-linear-gradient(right, #21d4fd, #b721ff, #21d4fd, #b721ff);  background: -moz-linear-gradient(right, #21d4fd, #b721ff, #21d4fd, #b721ff);  background: linear-gradient(right, #21d4fd, #b721ff, #21d4fd, #b721ff);  top: 0;  left: -100%;  -webkit-transition: all 0.4s;  -o-transition: all 0.4s;  -moz-transition: all 0.4s;  transition: all 0.4s;}.login100-form-btn {  font-family: Poppins-Medium;  font-size: 15px;  color: #fff;  line-height: 1.2;  text-transform: uppercase;  display: -webkit-box;  display: -webkit-flex;  display: -moz-box;  display: -ms-flexbox;  display: flex;  justify-content: center;  align-items: center;  padding: 0 20px;  width: 100%;  height: 50px;}.wrap-login100-form-btn:hover .login100-form-bgbtn {  left: 0;}/*------------------------------------------------------------------[ Responsive ]*/@media (max-width: 576px) {  .wrap-login100 {    padding: 77px 15px 33px 15px;  }}/*------------------------------------------------------------------[ Alert validate ]*/.validate-input {  position: relative;}.alert-validate::before {  content: attr(data-validate);  position: absolute;  max-width: 70%;  background-color: #fff;  border: 1px solid #c80000;  border-radius: 2px;  padding: 4px 25px 4px 10px;  top: 50%;  -webkit-transform: translateY(-50%);  -moz-transform: translateY(-50%);  -ms-transform: translateY(-50%);  -o-transform: translateY(-50%);  transform: translateY(-50%);  right: 0px;  pointer-events: none;  font-family: Poppins-Regular;  color: #c80000;  font-size: 13px;  line-height: 1.4;  text-align: left;  visibility: hidden;  opacity: 0;  -webkit-transition: opacity 0.4s;  -o-transition: opacity 0.4s;  -moz-transition: opacity 0.4s;  transition: opacity 0.4s;}.alert-validate::after {  content: "\f06a";  font-family: FontAwesome;  font-size: 16px;  color: #c80000;  display: block;  position: absolute;  background-color: #fff;  top: 50%;  -webkit-transform: translateY(-50%);  -moz-transform: translateY(-50%);  -ms-transform: translateY(-50%);  -o-transform: translateY(-50%);  transform: translateY(-50%);  right: 5px;}.alert-validate:hover:before {  visibility: visible;  opacity: 1;}@media (max-width: 992px) {  .alert-validate::before {    visibility: visible;    opacity: 1;  }}              </style>			  <style>.container-login100 { background-image: url("/background-login.jpg");background-repeat: no-repeat ;}.wrap-login100 {    width: 390px;    background: #fff;    border-radius: 10px;    overflow: hidden;    padding: 77px 55px 33px 55px;    -moz-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);    -webkit-box-shadow: 0 5px 13px 13px rgba(0, 0, 0, 0.1);    -o-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);    -ms-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);}</style>    <nav class='navbar navbar-inverse '><div class='container-fluid'>    <div class="navbar-header" style="float: left;"><img src="/cbh.png" style="width: 40px;height: 40px;margin-top: 5px;margin-right: 5px;" alt=""></div><center><a href="/"><i class="fas fa-arrow-left"></i> Quay lại trang chủ</a><center><span class='icon-bar'></span><span class='icon-bar'></span><span class='icon-bar'></span></button></div><div class='collapse navbar-collapse' id='myNavbar'><ul class='nav navbar-nav'><li class=''><a href='https://tunganh03.github.io/doantruong-cbh/'>Trang chủ</a></li><li class=''><a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href='/tracuu'>Tra cứu</a><div class="dropdown-menu" aria-labelledby="navbarDropdown">		  <a class="dropdown-item " style="    margin-left: 10px;" href="/loivipham">Các lỗi vi phạm</a><br>          <a class="dropdown-item " style="    margin-left: 10px;" href="/thoikhoabieu">Thời khoá biểu</a><br>          <a class="dropdown-item " style="    margin-left: 10px;" href="/hocsinh">Học sinh</a>        </div></li><li class=''><a href='/topvipham'>Top vi phạm</a></li><li class=''><a href='/hoatdong'>Hoạt động/Sự kiện</a></li><li class='active'><a href='/baocao'>Báo cáo</a></li><li class=''><a href='/lienhe'>Liên hệ</a></li></ul><ul class='nav navbar-nav navbar-right flex-row justify-content-between ml-auto'><li class="dropdown order-1">                    <button type="button" id="dropdownMenu1" data-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle" style="    margin-top: 8px;"><i class="fas fa-sign-in-alt"></i> Đăng nhập <span class="caret"></span></button>                    <ul class="dropdown-menu dropdown-menu-right mt-2">                       <li class="px-3 py-2" style="    height: 196px;    width: 240px;    padding-top: 15px;    padding-right: 15px;    padding-left: 15px;">   <form class="form" role="form" action="welcome.php" method="POST">                                <div class="form-group">                                    <input id="emailInput" placeholder="Email" class="form-control form-control-sm" type="text" required="">                                </div>                                <div class="form-group">                                    <input id="passwordInput" placeholder="Mật khẩu" class="form-control form-control-sm" type="text" required="">                                </div>                                <div class="form-group">                                    <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>                                </div>                                <div class="form-group text-center">                                    <small><a href="#" data-toggle="modal" data-target="#modalPassword">Quên mật khẩu?</a></small>                                </div>                            </form>                        </li>                    </ul>                </li></ul></div></div></nav>	<div class="limiter">		<div class="container-login100">			<div class="wrap-login100" style="padding-top: 60px;">									<span class="login100-form-title p-b-26">						Register a <br> new account					</span> <div class="" >            <div class="form" >                                <form method ="post" action="register.php">                    <div class="form-group">                        <div><input type="text" class="form-control" name="name" placeholder="Họ và tên"></div>                        <span class="text-danger"> </span>                    </div>                    <div class="form-group">                        <input type="text" class="form-control" name="email" placeholder="Email">                        <span class="text-danger"> </span>                    </div>                    <div class="form-group">                        <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập">                        <span class="text-danger"> </span>                    </div>                    <div class="form-group">                        <input type="password" class="form-control" name="password" placeholder="Mật khẩu">                        <span class="text-danger"> </span>                    </div>                    <div class="form-group">                        <input type="password" class="form-control" name="confirm_password" placeholder="Nhập lại mật khẩu"  >                        <span class="text-danger"> </span>                    </div><p style="color:red;text-align:center"><?php echo $message ?></p>					<div class="container-login100-form-btn">						<div class="wrap-login100-form-btn">							<div class="login100-form-bgbtn"></div>                            							<button class="login100-form-btn">								Đăng ký							</button>						</div>					</div>                </form>					            </div>        </div>										<div class="text-center p-t-20">                        hoặc đăng ký bằng...                    </div><div class="text-center p-t-10"><div class="row" style="text-align: center;margin-left: 0px;margin-right: 30px;"><div class="col-12"><a type="button" href="#" class="col-1" style="color: rgb(221, 75, 57);"><i class="fab fa-2x fa-google-plus"></i></a> <a type="button" href="#" class="col-1" style="color: rgb(59, 89, 152);"><i class="fab fa-2x fa-facebook"></i></a>  <a type="button" href="#" class="col-1" style="color: rgb(51, 51, 51);"><i class="fab fa-2x fa-github"></i></a></div></div></div>					<script>					function myFunction() {  var x = document.getElementById("myInput");  if (x.type === "password") {    x.type = "text";  } else {    x.type = "password";  }}					</script>								<center style="padding-top:20px;"><a href="/baocao">Đã có tài khoản?</a></center>			</div>		</div>	</div>        <!-- Javascript -->        <script src="assets/js/jquery-1.11.1.min.js"></script>        <script src="assets/bootstrap/js/bootstrap.min.js"></script>        <script src="assets/js/jquery.backstretch.min.js"></script>        <script src="assets/js/scripts.js"></script>                <!--[if lt IE 10]>            <script src="assets/js/placeholder.js"></script>        <![endif]--></div>      <footer class="footer">		<hr>		<div class="main-content" style="    margin-right: 15px;    margin-left: 15px;">    <div class="column">        <p>&copy; Đoàn trường Chuyên Biên Hoà</p>    </div>    <div class="column">        <p id="demo"></p>    </div>     <div class="column">        <p> Designed and developed with <i class="fas fa-heart"></i> by <a href="https://facebook.com/tunnaduong/">Fatties Software</a></p>    </div></div><style>.column {        display: inline-block;}</style></div><script>function myFunction() {  var d = new Date();  var n = d.getFullYear();  document.getElementById("demo").innerHTML = n + ".";}myFunction()</script>      </footer>      <!-- Bootstrap nhân JavaScript    ================================================== -->    <!-- Đặt ở cuối mã trang web để trang tải nhanh hơn -->    <!-- IE10 viewport hack cho Surface/bug máy tính bàn Windows 8 -->    <script src="https://v4-alpha.getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script><script src="//code.tidio.co/xk9nqvz3a3dzutblmspl6ct5spdbueji.js"> </script>  </body></html>