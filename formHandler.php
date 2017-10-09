<?php
	try{

		$table = "userInformation";
		//izveidoju savienojumu izmantojot php pdo.
		$pdo = new PDO("mysql:host=localhost", "root", '');
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
	    
		}catch(Exception $e){
			echo $sql . "" . $e->getMessage();
	}

//funkcija priekš datubāzes izveidošanas, ja tā neeksistē.
	function createDatabase($pdo)
	{
	    	$sql = "CREATE DATABASE IF NOT EXISTS personData";
	    	$pdo->exec($sql);
			//nosaku, ka jāizmanto datubāze ar nosaukumu personData.
	    	$sql = "use personData";
	    	$pdo->exec($sql);
	    	header("url=index.html");
	    }
//funkcija tabulas izveidei ja tādas vēl nav.
   function createTable($pdo,$tablevar)
   {
   			$sql = "CREATE TABLE IF NOT EXISTS $tablevar(
	    	ID INT(11) AUTO_INCREMENT PRIMARY KEY,
	    	Name VARCHAR(50) NOT NULL,
	    	Surname VARCHAR(50) NOT NULL,
	    	Company VARCHAR(50) NOT NULL,
	    	Address VARCHAR(100) NOT NULL,
	    	PhoneNumber INT(20) NOT NULL,
	    	Email VARCHAR(50) NOT NULL);";

    		$pdo->exec($sql);

    		
   }
//funkcija, kas iegūst datus no formas un tos saglaba datubaze.
   function saveData($pdo)
   {
   		
	   		$name=$_POST['name'];
	   		$surname=$_POST['surname'];
	   		$company=$_POST['company'];
	   		$address=$_POST['address'];
	   		$phonenumber=$_POST['phonenumber'];
	   		$email = $_POST['email'];

			$query="INSERT INTO userInformation(Name,Surname,Company,Address,PhoneNumber,Email) VALUES (:name,:surname,:company,:address,:phonenumber,:email)";
			$update = $pdo->prepare($query);
			$execute= $update-> execute(array(
				':name' => $name,
				':surname' => $surname,
				':company' => $company,
				':address' => $address,
				':phonenumber' => $phonenumber,
				':email' => $email,
				));		
   }

   //pasta sūtīšanas funkcija
   function sendMail(){
   	$to = $_POST['email'];
	$subject = 'YOUR REGISTRATION';
	$message = 'HELLO! YOU HAVE BEEN REGISTERED FOR THIS EVENT!';
	$headers = 'From: admin@test.com' . "\r\n" .
    'Reply-To: admin@test.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);
   }
   header("refresh:5;url=index.html");


	$createDB = createDatabase($pdo);
	$createTable = createTable($pdo,$table);
	$saveData = saveData($pdo);
	$sendMail = sendMail();
	$pdo = null;
	exit();
 	
?>
	
 
