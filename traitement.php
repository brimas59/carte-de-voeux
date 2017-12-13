<?php

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=brigittem_db;charset=utf8', 'brigittem', 'ArEGbcBeFl');
	//$bdd = new PDO('mysql:host=localhost;dbname=carte_de_voeux;charset=utf8', 'root', '');
 
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


$name=$_POST['name'];
$email=$_POST['email'];
$objet=$_POST['objet'];
$message=$_POST['message'];


 
 
//On prépare la commande sql d'insertion


$tatement = $bdd->prepare("INSERT INTO carte (name, email, objet, message) VALUES (:name, :email, :objet, :message )");

   $tatement ->bindParam('name', $name);

   $tatement ->bindParam('email', $email);

   $tatement ->bindParam('objet', $objet);

   $tatement ->bindParam('message', $message);

   $tatement ->execute();      
   
   $tatement ->closeCursor(); 

   
   
 
    /*
    	********************************************************************************************
    	CONFIGURATION
		********************************************************************************************
		
		
    */
	// destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
	

		
	$object = 'meilleurs voeux';
	
	$to = 'brigitte.m@codeur.online';
	
		
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	
	
	if(mail($to, $object, $message, $headers)) {
		echo "test";
	}
	else {
		echo "raté";
	}



	
	
	

		




	
     
    /* copie ? (envoie une copie au visiteur)
    $copie = 'non';
     
    // Action du formulaire (si votre page a des paramètres dans l'URL)
    // si cette page est index.php?page=contact alors mettez index.php?page=contact
    // sinon, laissez vide
    $form_action = '';
     
    // Messages de confirmation du mail
    $message_envoye = "Votre message nous est bien parvenu !";
    $message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
     
    // Message d'erreur du formulaire
	$message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";
	
	


     
    /*
    	********************************************************************************************
    	FIN DE LA CONFIGURATION
    	********************************************************************************************
    */
     
    /*
     * cette fonction sert à nettoyer et enregistrer un texte
     */
    /*function Rec($text)
    {
    	$text = htmlspecialchars(trim($text), ENT_QUOTES);
    	if (1 === get_magic_quotes_gpc())
    	{
    		$text = stripslashes($text);
    	}
     
    	$text = nl2br($text);
    	return $text;
    };
     
    /*
     * Cette fonction sert à vérifier la syntaxe d'un email
     */
    /*function IsEmail($email)
    {
    	$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
    	return (($value === 0) || ($value === false)) ? false : true;
    }
     
    // formulaire envoyé, on récupère tous les champs.
    $nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
    $email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
    $objet   = (isset($_POST['objet']))   ? Rec($_POST['objet'])   : '';
    $message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
     
    // On va vérifier les variables et l'email ...
    $email = (IsEmail($email)) ? $email : 'masson-b@orange.fr'; // soit l'email est vide si erroné, soit il vaut l'email entré
    $err_formulaire = false; // sert pour remplir le formulaire en cas d'erreur si besoin
     
    if (isset($_POST['envoi']))
    {
		if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
		mail($to, $object, $message, $headers);
    	{
    		// les 4 variables sont remplies, on génère puis envoie le mail
    		$headers  = 'From:'.$nom.' <'.$email.'>' . "\r\n";
    		//$headers .= 'Reply-To: '.$email. "\r\n" ;
    		//$headers .= 'X-Mailer:PHP/'.phpversion();
     
    		// envoyer une copie au visiteur ?
    		if ($copie == 'oui')
    		{
    			$cible = $destinataire.';'.$email;
    		}
    		else
    		{
    			$cible = $destinataire;
    		};
     
    		// Remplacement de certains caractères spéciaux
    		$message = str_replace("&#039;","'",$message);
    		$message = str_replace("&#8217;","'",$message);
    		$message = str_replace("&quot;",'"',$message);
    		$message = str_replace('&lt;br&gt;','',$message);
    		$message = str_replace('&lt;br /&gt;','',$message);
    		$message = str_replace("&lt;","&lt;",$message);
    		$message = str_replace("&gt;","&gt;",$message);
    		$message = str_replace("&amp;","&",$message);
     
    		// Envoi du mail
    		$num_emails = 0;
    		$tmp = explode(';', $cible);
    		foreach($tmp as $email_destinataire)
    		{
    			if (mail($email_destinataire, $objet, $message, $headers))
    				$num_emails++;
    		}
     
    		if ((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1)))
    		{
    			echo '<p>'.$message_envoye.'</p>';
    		}
    		else
    		{
    			echo '<p>'.$message_non_envoye.'</p>';
    		};
    	}
    	else
    	{
    		// une des 3 variables (ou plus) est vide ...
    		echo '<p>'.$message_formulaire_invalide.'</p>';
    		$err_formulaire = true;
    	};
    };  fin du if (!isset($_POST['envoi']))*/
     
    
    ?>
