<!doctype html>
<?php
session_start();

if(empty($_SESSION['login_user'])){
    echo "<meta http-equiv='refresh' content='0;url=/cms/index.php'>";
}
else{

if($_SESSION['user'] == 0){



$servername = "localhost";
$username="root";
$password="";
$dbname="csm";
$error=''; 
try{
$conn = mysqli_connect($servername, $username,$password,$dbname);
//echo("Reģistrēties");
}catch(MySQLi_Sql_Exception $ex){
//echo("Radās kļūda, mēģiniet vēlreiz!");
}
if(isset($_POST['submit'])){
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$age=$_POST['age'];
$gender=$_POST['gender'];
$email=$_POST['email'];
$user = $_POST['username'];
$pass = $_POST['password'];
$pass = sha1($pass);
$access = $_POST['access'];
$register_query = "INSERT INTO `users`(`fname`, `lname`, `age`, `gender`, `email`, `username`, `password`,`access`) VALUES ('$fname','$lname', '$age','$gender','$email','$user','$pass','$access')";
$username_check_query = mysqli_query($conn, "select * from users where username='$user'");
if (mysqli_num_rows($username_check_query)== 0) {
	try{
$register_result = mysqli_query($conn, $register_query);
if($register_result){
if(mysqli_affected_rows($conn)>0){
echo('<div class="alert alert-success" align="center">
    <strong>Apsveicam!</strong> Reģistrācija ir veiksmīga! Dodies uz sākumu, lai pieslēgtos! <a href="index.php">Uz sākumu</a>
  </div>');

}else{
echo("Klūda reģistrācijā");
}
 
}
}catch(Exception $ex){
echo("error".$ex->getMessage());
}
}

else {
	$error ="<font color='red'><b><i><br>Jau eksistē lietotājs ar šādu lietotājvārdu!</i></b></font> ";
}


}
 
?>
<html>

<head>
	<link rel="icon" href="favicon.ico" type="image/ico">
	<link rel="stylesheet" type="text/css" href="style.css">
	
	<meta charset="utf-8">
	<title>Pievienoties</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
 
<body background="start-background.jpg">
<br><br><br>
<form action="" method="post" id="forma">
<table align="center">
<p> <h2 align="center" id="regisText">Reģistrācija</h2> <p>
<tr>
<td>Vārds:</td>
<td><input type="text" name="fname" placeholder="Ievadiet savu vārdu" id="name"></td>
</tr>

<tr>
<td>Uzvārds:</td>
<td><input type="text" name="lname" placeholder="Ievadiet savu uzvārdu"id="surname"></td>
</tr>

<tr>
<td>Vecums:</td>
<td><input type="number" name="age" min="0" max="110" placeholder="12" id="age"><br></td>
</tr>

<tr>
<td>Dzimums</td>
<td><input type="radio" name="gender" value="Vīrietis" id="gender">Vīrietis</td>
</tr>

<tr>
<td></td>
<td><input type="radio" name="gender" value="Sieviete" id="gender" placeholder="12">Sieviete</td>
</tr>
 
<tr>
<td>E-pasts:</td>
<td><input type="email" name="email" placeholder="piemers@piemers.lv" id="email"></td>
</tr>
 
<tr>
<td>Lietotājvārds: </td>
<td><input type="text" name="username" placeholder="Ievadiet lietotājvārdu" id="username"></td>
</tr>
 
<tr>
<td>Parole:</td>
<td><input type="password" name="password" placeholder="******" id="password"></td>
</tr>
<tr>

<tr>
<td>Parole atkārtoti:</td>
<td><input type="password" placeholder="******" id="password2"></td>
</tr>
<tr>

<tr>
<td>Piekļuves līmenis</td>
<td><input type="radio" name = "access" value = "0" placeholder="1" id="access"> Administrator</td>
</tr>
<tr>
<tr>
<td></td>
<td><input type="radio" name = "access" value = "1" placeholder="1" id="access">User</td>
</tr>
<tr>

<tr>

<tr>
<td></td>
<td><input type="submit" name="submit" value="Reģistrēties" id="submit" onclick="myFunction()"></td>
</tr>
</table>
<tr>
<td></td>
<td><?php echo $error; ?></td>
</tr>
<p><a href="/cms/admin.php">Uz Administracijas paneli</a></p>
<p><a href="why.html">Informācija</a></p>

</form>

<script>
var forma = document.getElementById('forma');
function validateForm(event) {

	var name = document.getElementById('name');
	var surname = document.getElementById('surname');
	var age = document.getElementById('age');
	var gender = document.getElementById('gender');
	var email = document.getElementById('email');
	var username = document.getElementById('username');
	var password = document.getElementById('password');
	var password2 = document.getElementById('password2');
	var emailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var access = document.getElementById('access');
	
	if (name.value === "" ) {
		alert("Ievadiet vārdu!");	
		event.preventDefault(); //Apturēt formas nosūtīšanu		
	}
	else if(surname.value === "") {
		alert("Ievadiet uzvārdu!");
		event.preventDefault();
	}
	else if(age.value === "") {
		alert("Nav norādīts vecums!");
		event.preventDefault();
	}
	else if(!(age.value > 11 && age.value <111)) {
		alert("Jums jābūt sasniegušam 12 gadu vecumu, lai varētu iesniegt šo formu!");
		event.preventDefault();
	}
	else if ((forma.gender[0].checked == false) && (forma.gender[1].checked == false)) {
		alert ( "Nav norādīts dzimums!" ); 
		event.preventDefault();
	}	
	else if(email.value === "") {
		alert("Nav norādīta e-pasta adrese!");
		event.preventDefault();
	}
	else if (!(email.value.match(emailformat))) {
		alert("Epasta adrese nav atpazīta! Epasta adreses piemērs: vardsuzvards@piemers.lv");
		event.preventDefault();
	}
	else if(username.value === "") {
		alert("Nav norādīts lietotājvārds!");
		event.preventDefault();
	}
	else if(!(username.value.length > 4)) {
		alert("Pārliecinieties, vai lietotājvārds satur vismaz 5 simbolus!");
		event.preventDefault();
	}
	else if(!(password.value.length > 7)) {
		alert("Pārliecinieties, vai parole satur vismaz 8 simbolus!");
		event.preventDefault();
	}	
	else if(!(password.value==password2.value)) {
		alert("Ievadītās paroles nav vienādas!");
		event.preventDefault();
	}
	else if ((forma.access[0].checked == false) && (forma.access[1].checked == false) && (forma.access[2].checked == false)) {
		alert("Nav norādīts access līmenis!");
		event.preventDefault();
	}

	forma.submit();


}
forma.addEventListener("submit", validateForm, false);
</script>

</body>
</html>

<?php
}else{
    echo "<meta http-equiv='refresh' content='0;url=/./index.php'>";
}

}