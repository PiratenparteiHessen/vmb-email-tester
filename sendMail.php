<?php
/**
 * Created by PhpStorm.
 * User: nowrap
 * Date: 13.09.2015
 * Time: 14:19
 */

header("content-type:application/json");

session_start();

if ($_POST["action"] == "sendMail") {
	if (hash_hmac('sha256', $_SESSION['uuid'], $_SERVER['REMOTE_ADDR']) != $_POST["uuid"]) {
		echo json_encode("no valid uuid");
		exit();
	}

	$email = $_POST["email"];
	$email = trim($email);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo json_encode("no valid email");
		exit();
	}

	$config = new stdClass;
	$config->adminname = "Piratenpartei Hessen";
	$config->adminmail = "kontakt@piratenpartei-hessen.de";
	$config->replytomail = "noreply@piratenpartei-hessen.de";
	$config->charset = "UTF-8";

	$generate = false;
	$invalidize = false;
	$header = "From: {$config->adminname} <{$config->adminmail}>\r\nReply-To: {$config->replytomail}\r\nContent-Type: text/plain; Charset={$config->charset}";
	switch ($_POST["target"]) {
		case "test":
			$subject = "[vMB E-Mail Tester] Test E-Mail";
			$body = file_get_contents("templates/test_email.txt");
			break;


		case "vMB1-token":
			$subject = "[PPH Umfrage] Umfrage zum Logo des Landesverbandes";
			$body = file_get_contents("templates/vmb_1.txt");
			$generate = true;
			break;

		case "vMB1":
			$subject = "[PPH Umfrage] Umfrage zum Logo des Landesverbandes";
			$body = file_get_contents("templates/vmb_1.txt");
			break;


		case "vMB2-token":
			$subject = "[PPH Umfrage] Unterstützung der Ramstein Kampagne";
			$body = file_get_contents("templates/vmb_2.txt");
			$generate = true;
			$invalidize = true;
			break;

		case "vMB2":
			$subject = "[PPH Umfrage] Unterstützung der Ramstein Kampagne";
			$body = file_get_contents("templates/vmb_2.txt");


		case "vMB3-token":
			$subject = "[PPH Umfrage] Forderungen der Ramstein Kampagne";
			$body = file_get_contents("templates/vmb_3.txt");
			$generate = true;
			$invalidize = true;
			break;

		case "vMB3":
			$subject = "[PPH Umfrage] Forderungen der Ramstein Kampagne";
			$body = file_get_contents("templates/vmb_3.txt");
			break;


		default:
			echo json_encode("no valid target");
			exit();
	}


	$token = "";
	$optouttoken = "";
	if ($generate) {
		$token = gentoken();
		$optouttoken = gentoken();
	}
	if ($invalidize) {
		$token = substr($token, 1, -1);
		$optouttoken = substr($optouttoken, 1, -1);
	}

	$body = str_replace("{%token%}", $token, $body);
	$body = str_replace("{%token_url%}", urlencode($token), $body);
	$body = str_replace("{%optout_url%}", urlencode($optouttoken), $body);

	// Benutze auch im Header unseren Zeichensatz
	mb_internal_encoding($config->charset);
	$subject = mb_encode_mimeheader($subject, $config->charset);

	/* Zu dem CRLF ... wenn ich einen regulaeren \r\n benutze, machen
	 * manche Webmailer & POP3-Dienste Probleme.
	 */
	$subject = preg_replace("$\r?\n$","\n",$subject);

	/* RFC 2822: "Each line of characters MUST be no more than 998
	 * characters, and SHOULD be no more than 78 characters, excluding
	 * the CRLF."
	 */
	$body = preg_replace("$\r?\n$","\n",$body);
	$body = wordwrap($body,998,"\n",true);
	$body = wordwrap($body,78,"\n");

	/* RFC 2822 verlangt \r\n als Zeilentrenner im Header
	 * Notiz von http://www.php.net/mail :
	 * If messages are not received, try using a LF (\n) only.
	 * Some poor quality Unix mail transfer agents replace LF by CRLF
	 * automatically (which leads to doubling CR if CRLF is used).
	 * This should be a last resort, as it does not comply with RFC 2822.
	 */
	$header = preg_replace("$\r?\n$","\n",$header);

	$result = mail($email, $subject, $body, $header);

	$ret = array(
				"success" => $result,
				"dara"    => array(),
	);

	echo json_encode($ret);

} else {
	echo json_encode("no valid action");
}


function gentoken($len = 20) {
	$words = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789*?=/&%!"\'$(){}[]#-_.,:;<>|';
	$token = "";
	for ($i=0;$i<$len;$i++) {
		$token .= substr($words,rand(0,strlen($words)-1),1);
	}
	return $token;
}