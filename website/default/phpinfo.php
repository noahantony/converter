<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body> 

<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["name"])) {
     $nameErr = "Name is required";
   } else {
     $name = test_input($_POST["name"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
       $nameErr = "Only letters and white space allowed"; 
     }
   }
   
   if (empty($_POST["email"])) {
     $emailErr = "Email is required";
   } else {
     $email = test_input($_POST["email"]);
     // check if e-mail address is well-formed
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $emailErr = "Invalid email format"; 
     }
   }
     
   if (empty($_POST["website"])) {
     $website = "";
   } else {
     $website = test_input($_POST["website"]);
     // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
     if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
       $websiteErr = "Invalid URL"; 
     }
   }

   if (empty($_POST["comment"])) {
     $comment = "";
   } else {
     $comment = test_input($_POST["comment"]);
   }

   if (empty($_POST["gender"])) {
     $genderErr = "Gender is required";
   } else {
     $gender = test_input($_POST["gender"]);
   }
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<h2>Convertor from Tamil lyrics to Romanized version!</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<h3>Paste tamil lyrics here</h3>
   <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea><br>
   <input type="submit" name="submit" value="Convert"> 
</form>
<form action="clearContent.php" method="post">
 <input type="submit" name="submit" value="Clear"/>
</form>

<?php
echo "<h2>Romanized version of given lyrics:</h2>";
$file = 'files/tamilLyrics.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= $comment;
// Write the contents back to the file
file_put_contents($file, $current);
exec("java -jar tools/tamilscriptconverter.jar files/tamilLyrics.txt");
$romanizedFile = 'files/converted/tamilLyrics.txt';
$romanizedFileContent = file_get_contents($romanizedFile);
echo $romanizedFileContent;
echo "\n";
echo "<br>";
?>

</body>
</html>