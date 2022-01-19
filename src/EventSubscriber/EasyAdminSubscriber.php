<?php

namespace App\EventSubscriber;

use App\Entity\Basket;
use App\Entity\Invoice;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $security;
    private $entityManager;
    private $passwordEncoder;

    public function __construct(SluggerInterface $slugger, Security $security, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->slugger = $slugger;
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setProductDate'],
            BeforeEntityPersistedEvent::class => ['addUser'],
            BeforeEntityUpdatedEvent::class => ['updateUser'], //surtout utile lors d'un reset de mot passe plutôt qu'un réel update, car l'update va de nouveau encrypter le mot de  passe DEJA encrypté ...
        ];
    }

    public function setProductDate(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        $user = $this->security->getUser();
        $now = new DateTime('now');

        if ($entity instanceof Basket || $entity instanceof Invoice) {
            $entity->setCreatedAt($now);
        }
    }

    public function updateUser(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }
        // dd($entity);
        // $this->setPassword($entity);
    }

    public function addUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }
        $this->setPassword($entity);
    }

    /**
     * @param User $entity
     */
    public function setPassword(User $entity): void
    {
        $pass = $entity->getPassword();

        $entity->setPassword(
            $this->passwordEncoder->hashPassword(
                $entity,
                $pass
            )
        );
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}