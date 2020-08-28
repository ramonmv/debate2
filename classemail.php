<?php

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// $mail = new PHPMailer(true);

// try {
//     //Server settings
//     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
//     $mail->isSMTP();                                            // Send using SMTP
//     $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through

//     $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//     $mail->Username   = 'ramon.ead@gmail.com';                     // SMTP username
//     $mail->Password   = 'strcomp,,';                               // SMTP password
//     // $mail->Username   = 'laradock';                     // SMTP username
//     // $mail->Password   = 'laradock';                               // SMTP password
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; 
//     $mail->Port       = 587;                                   // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

//     //Recipients
//     $mail->setFrom('ramon.ead@gmail.com', 'Raaaamon');
//     $mail->addAddress('raamon@gmail.com', 'Joe User');     // Add a recipient
//     $mail->addAddress('karinacdonis@gmail.com');               // Name is optional

//     // Content
//     $mail->isHTML(true);                                  // Set email format to HTML
//     $mail->Subject = 'Karina é lindinha!!!!!';
//     $mail->Body    = 'Fazer <b>exercício</b> Karininhaaaaa ';
//     // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//     $mail->send();
//     if ($mail->send()) {
//         echo 'SUCESSSOOOOOOOOO';
//     }
//     else{
//         echo 'naoooo enviado!!!';   
//     }
//     // echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error:".$mail->ErrorInfo;
// }




Class EnvioEmail
{
	public $erro=null;
    public $mail;
        /**
         *
         * @param <type> $emailDestino
         * @param <type> $assunto
         * @param <type> $corpo
         */
	function EnvioEmail($emailDestino,$assunto, $corpo )
	{
		// return 0; 				
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        // $mail->isSMTP();                                            // Send using SMTP
        // $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        // $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        // $mail->Username   = 'ramon.ead@gmail.com';                     // SMTP username
        // $mail->Password   = 'strcomp,,';                               // SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; 
        // $mail->Port       = 587;                                    // TCP port to connect to, use 465 for 
        // $mail->addAddress('raamon@gmail.com', 'Joe User');     // Add a recipient
        // $mail->addAddress('karinacdonis@gmail.com');               // Name is optional
        // $mail->isHTML(true);                                  // Set email format to HTML
        // $mail->Subject = 'Karina é lindinha!!!!!';
        // $mail->Body    = 'Fazer <b>exercício</b> Karininhaaaaa ';
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        // $mail->send();

        //date_default_timezone_set('America/Toronto');
		$this->mail = new PHPMailer(true);
		$this->mail->IsSMTP(); // Define que a mensagem será SMTP
        $this->mail->CharSet = "UTF-8";
        // $this->mail->SMTPDebug   = SMTP::DEBUG_SERVER;                  // enable SMTP authentication
        // $this->mail->SMTPAuth   = true;                  // enable SMTP authentication
        $this->mail->Host       = 'relay.ufrgs.br';      // sets GMAIL as the SMTP server
        $this->mail->Port       = 25;                   // set the SMTP port for the GMAIL server
        // $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // set the SMTP port for the GMAIL server
        
        // $this->mail->Username   = "peadfaced@gmail.com";  // GMAIL username
        // $this->mail->Password   = "peadfaced.";            // GMAIL password

        
        $this->mail->SetFrom('naoresponda@servidor.nuvem.ufrgs.br', 'naoresponda@servidor.nuvem.ufrgs.br');
        // $this->mail->addReplyTo('peadfaced@gmail.com', 'Suporte Debate de Teses');

        $this->mail->Subject    = $assunto;
        $this->mail->AltBody    = "Para visualizar esta mensagem, é necessário habilitar o uso do HTML, ou utilizar um webmail compatível "; // optional, comment out and test

        // $this->mail->MsgHTML($corpo);
        $this->mail->Body = $corpo;
                
        $this->mail->addAddress($emailDestino, $emailDestino);	
        $this->mail->isHTML(true);
		
	}
	

	function enviar()
	{		
        // Envia o e-mail
		$enviado = $this->mail->Send();	
		// Exibe uma mensagem de resultado
		if ($enviado)
        {
		    return 1;
		} 
		else 
		{	
		  // echo "Mailer Error: " . $this->mail->ErrorInfo;
			return 0; 
		}
	}

}


?>
