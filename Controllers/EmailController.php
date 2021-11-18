<?php 

namespace Controllers;

class EmailController {


    public function SendMail($destinatario, $asunto, $cuerpo) {
    
    
    //para el envío en formato HTML 
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
    
    //dirección del remitente 
    $headers .= "From: Ofertas Laborales <acervigni92@gmail.com>\r\n"; 
    
    //direcciones que recibirán copia oculta 
    $headers .= "Bcc: arielcervigni@gmail.com\r\n"; 
    
    //$micorreo = "arielcervigni@gmail.com";
    return mail($destinatario,$asunto,$cuerpo,$headers); 
    }
}
 
?>