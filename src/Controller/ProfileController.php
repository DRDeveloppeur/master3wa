<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use App\Form\UpdateProfileFormType;
use App\Security\EmailVerifier;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }
    
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UpdateProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            // $user->setPassword(
            // $userPasswordHasherInterface->hashPassword(
            //         $user,
            //         $form->get('plainPassword')->getData()
            //     )
            // );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('raul3wa@gmail.com', 'Carrée de la mode'))
                    ->to($user->getEmail())
                    ->subject('Modifications des informations personnelles')
                    ->htmlTemplate('profile/email_update_profile.html.twig')
            );
            // do anything else you need here, like send an email

            $this->addFlash('success', 'Vos informations ont bien été modifiées. Vous recevrez bientôt un mail de confirmation.');
            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/index.html.twig', [
            'Form_update_profile' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/profile", name="profile_update_profile")
     */
    public function updateProfile(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('raul3wa@gmail.com', 'Carr�e de la mode'))
                    ->to($user->getEmail())
                    ->subject('Modifications des informations personnelles')
                    ->htmlTemplate('profile/email_update_profile.html.twig')
            );
            // do anything else you need here, like send an email

            $this->addFlash('success', 'Vos informations ont bien �t� modifi�es. Vous recevrez bient�t un mail de confirmation.');
            return $this->redirectToRoute('profile');
        }
        
        return new RedirectResponse($request->headers->get('referer'));
    }
}
