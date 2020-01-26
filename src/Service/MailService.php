<?php


namespace App\Service;

use App\Entity\Commande;

class MailService
{

    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendEmailForCommandSuccess(Commande $commande) {
        $message = (new \Swift_Message('GROLIDON - confirmation de la commande'))
            ->setFrom(['tomdfordev@gmail.com' => 'Tom de GROLIDON'])
            ->setTo($commande->getUsager()->getEmail())
            ->setBody(
                $this->templating->render(
                    'mail/mailCommandSuccess.html.twig'
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

}