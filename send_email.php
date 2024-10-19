<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir PHPMailer
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Método no permitido. Por favor, utiliza el formulario para enviar el mensaje.';
    exit;
}

// Datos del formulario
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$message = $_POST['message'];

// Validación de los datos recibidos
if (empty($fname) || empty($lname) || empty($email) || empty($telephone) || empty($message)) {
    echo "Todos los campos son obligatorios.";
    exit;
}

$mail = new PHPMailer(true); // Crear una instancia de PHPMailer con manejo de excepciones

try {
    // Configuración del servidor SMTP de SiteGround
    $mail->isSMTP();
    $mail->Host = 'giowm1116.siteground.biz';  // Servidor SMTP de SiteGround
    $mail->SMTPAuth = true;
    $mail->Username = 'contactus@artforchildrencolombia.org';  // Dirección de correo electrónico de contacto
    $mail->Password = '@rtF0rCh1ldr3nC0l0mb1@'; // Contraseña de tu cuenta de correo
    $mail->SMTPSecure = 'ssl';                 // Habilitar encriptación SSL
    $mail->Port = 465;                         // Puerto de SMTP seguro (SSL)

    // Remitente y destinatario
    $mail->setFrom('contactus@artforchildrencolombia.org', 'Nombre');  // Remitente es el correo de quien completó el formulario
    $mail->addAddress('contactus@artforchildrencolombia.org'); // Dirección de la fundación

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Pregunta o comentario enviado desde la pagina';
    $mail->Body    = '<h1>Información enviada</h1>' .
                     '<p><strong>Nombre:</strong> ' . htmlspecialchars($fname . ' ' . $lname) . '</p>' .
                     '<p><strong>Email:</strong> ' . $email . '</p>' .
                     '<p><strong>telephone:</strong> ' . $telephone . '</p>' .
                     '<p><strong>Message:</strong><br>' . nl2br($message) . '</p>';
    $mail->AltBody = 'Nombre: ' . $fname . ' ' . $lname . '\nEmail: ' . $email . '\nTeléfono: ' . $telephone . '\nMensaje: ' . $message;

    // Establecer la codificación en UTF-8
    $mail->CharSet = 'UTF-8';
    
    // Enviar el correo
    $mail->send();
    echo 'El mensaje ha sido enviado exitosamente.';
} catch (Exception $e) {
    echo "El mensaje no pudo ser enviado. Error de PHPMailer: {$mail->ErrorInfo}";
}
?>