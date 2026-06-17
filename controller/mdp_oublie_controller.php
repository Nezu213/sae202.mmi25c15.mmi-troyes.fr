<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['email']) && !empty($_POST['email'])) {
    
    require_once '../view/bdd.php';
    $email = trim($_POST['email']);

    // 1. On cherche l'utilisateur
    $stmt = $link->prepare("SELECT user_id, user_pseudo FROM user WHERE user_email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // 2. Génération d'un token sécurisé aléatoire et d'une expiration (+30 min)
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        // 3. Sauvegarde du token en BDD
        $update = $link->prepare("UPDATE user SET user_reset_token = ?, user_reset_expires = ? WHERE user_id = ?");
        $update->execute([$token, $expires, $user['user_id']]);

        // 4. Construction du lien de récupération absolu vers ton site
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $url_reinitialisation = $protocol . $host . "/sae202_event/reset_password.php?token=" . $token;

        // 5. Envoi du Mail réel
        $to = $email;
        $subject = "=?UTF-8?B?".base64_encode("Night Casino - Récupération de mot de passe")."?=";
        
        $message = "Bonjour " . htmlspecialchars($user['user_pseudo']) . ",\r\n\r\n";
        $message .= "Une demande de réinitialisation de mot de passe a été effectuée pour votre espace équipe.\r\n";
        $message .= "Cliquez sur le lien ci-dessous pour modifier votre mot de passe (Lien valide 30 minutes) :\r\n";
        $message .= $url_reinitialisation . "\r\n\r\n";
        $message .= "Si vous n'êtes pas à l'origine de cette demande, ignorez cet e-mail.\r\n";
        $message .= "L'équipe du Night Casino.";

        $headers = "From: Night Casino <no-reply@" . $host . ">\r\n";
        $headers .= "Reply-To: no-reply@" . $host . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            header('Location: ../mdp_oublie.php?success=sent');
        } else {
            // Si le serveur refuse l'envoi de mail()
            header('Location: ../mdp_oublie.php?error=mail_failed');
        }
        exit;
    } else {
        header('Location: ../mdp_oublie.php?error=not_found');
        exit;
    }
} else {
    header('Location: ../mdp_oublie.php');
    exit;
}