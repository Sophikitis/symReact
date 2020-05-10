<?php


namespace App\Events;


use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedSubscriber
{

    /**
     * Permet de customiser le payload du token en ajoutant des données supplementaire
     * @param JWTCreatedEvent $event
     */
    public function updateJwtData(JWTCreatedEvent $event)
    {
        // Récupére l'instance d'user et les data du token
        /** @var User $user */
        $user = $event->getUser();
        $data = $event->getData();

        // Ajout de données supplementaire
        $data['firstName'] = $user->getFirstName();
        $data['lastName'] = $user->getLastName();

        // Insére les nouvelles données
        $event->setData($data);

    }


}