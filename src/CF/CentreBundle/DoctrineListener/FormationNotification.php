<?php

namespace CF\CentreBundle\DoctrineListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use CF\CentreBundle\Entity\Formation;

class FormationNotification
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    // Envoi du message
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // Si l'événement provient d'une autre entity que Formation -> stop
        if(!$entity instanceof Formation)
            return;
        // Si un formateur est lié à la formation
        if($entity->getFormateur() !== null)
        {
            $message = new \Swift_Message(
                'Nouvelle formation',
                'Cher '.$entity->getFormateur()->getNomComplet().',
            Vous avez reçu une nouvelle formation à donner.'
            );

            $message
                ->addTo($entity->getFormateur()->getEmail())
                ->addFrom('linard.gauthier@gmail.com')
            ;

            $this->mailer->send($message);
        }
    }
}