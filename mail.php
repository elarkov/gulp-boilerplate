<?php

if (empty($_POST['phone'])) exit('Заполните все данные');

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

$name = $_POST['name'];                                             
$phone = $_POST['phone'];
$formSubject = $_POST['form_subject'];  

$mail = new PHPMailer\PHPMailer\PHPMailer();   

try{
	
	$msg = "ok";
	$mail->SMTPDebug = 0;
  // $mail->isSMTP();   
  $mail->CharSet = "UTF-8";                                          
	$mail->SMTPAuth   = true;	
	
	$mail->Host = 'smtp.gmail.com';                                                    
	$mail->Username = 'simple@gmail.com';                 //почта клиента через которую происходит отправка
	$mail->Password = '';                 //пароль от почты клиента
	$mail->SMTPSecure = 'ssl';                            
	$mail->Port = 465; 
	
	$mail->setFrom('simple@gmail.com', '');  //почта клиента через которую происходит отправка
	$mail->addAddress('simple@gmail.com');        //адрес почты куда будут приходить заявки с сайта

	// Прикрипление файлов к письму
	if (!empty($_FILES['myfile']['name'][0])) {
		for ($ct = 0; $ct < count($_FILES['myfile']['tmp_name']); $ct++) {
			$uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['myfile']['name'][$ct]));
			$filename = $_FILES['myfile']['name'][$ct];
			if (move_uploaded_file($_FILES['myfile']['tmp_name'][$ct], $uploadfile)) {
				$mail->addAttachment($uploadfile, $filename);
			} else {
				$msg .= 'Неудалось прикрепить файл ' . $uploadfile;
			}
		}   
	}

	$mail->isHTML(true);                                    
	$mail->Subject = 'Заявка с сайта <НАЗВАНИЕ САЙТА>';
	$mail->Body    = '<h2>Заявка с формы - '. $formSubject . '</h2>
					<table style="border-collapse: collapse;">
						<tr style="background-color: #f8f8f8;">
							<th style="padding: 10px; border: #e9e9e9 1px solid;"><b>Имя</b></th>
							<th style="padding: 10px; border: #e9e9e9 1px solid;"><b>Телефон</b></th>
						</tr>
						<tr>
							<td style="padding: 10px; border: #e9e9e9 1px solid;">' . $name . '</td>
							<td style="padding: 10px; border: #e9e9e9 1px solid;">' . $phone . '</td>
						</tr>
					</table>';

	if ($mail->send()) {
		echo "$msg";
	} else {
		echo "Сообщение не было отправлено. Неверно указаны настройки вашей почты";
	}

} catch (Exception $e) {
	echo "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

?>