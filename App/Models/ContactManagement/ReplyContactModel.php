<?php

namespace Models\ContactManagement;

use App\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ReplyContactModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function sendReply($contactId, $replyMessage)
    {
        $request = "SELECT firstname, lastname, email FROM contact WHERE id = ?";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$contactId]);
        $contact = $pdo->fetch();

        if (!$contact) 
        {
            throw new \Exception("Contact introuvable.");
        }

        $firstname = $contact['firstname'];
        $lastname = $contact['lastname'];
        $email = $contact['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            throw new \Exception("Adresse email invalide.");
        }

        // Initialisation de PHPMailer
        $mail = new PHPMailer(true);

        try 
        {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'hokablese@gmail.com';
            $mail->Password   = 'wmkhtcabgwhoqwbh';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            // Expéditeur
            $mail->setFrom('hokablese@gmail.com', 'Baser Facade');

            // Destinataire
            $mail->addAddress($email, "$firstname $lastname");

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = "Réponse à votre message";
            $mail->Body    = "<p>Bonjour $firstname $lastname,</p><p>$replyMessage</p><p>Cordialement,</p>";

            // Envoi de l'email
            $mail->send();

            // Mise à jour du statut à "Répondu"
            $this->updateMessageStatus($contactId, 'Répondu');

            return true; // Retourne un succès simple
        } 
        catch (Exception $e) 
        {
            throw new \Exception("Erreur lors de l'envoi du mail : {$mail->ErrorInfo}");
        }
    }

    // Fonction pour mettre à jour le statut du message
    public function updateMessageStatus($contactId, $newStatus)
    {
        $request = "UPDATE contact SET status_id = (SELECT id FROM status_contact WHERE name = ?) WHERE id = ?";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$newStatus, $contactId]);
    }
}
