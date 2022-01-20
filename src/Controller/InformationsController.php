<?php

namespace App\Controller;

use App\Repository\MarkRepository;
use App\Repository\StoreRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/informations")
 */
class InformationsController extends AbstractController
{
    /**
     * @Route("/qui-sommes-nous", name="informations_who")
     */
    public function whoAreWe(): Response
    {
        return $this->render('informations/qui-sommes-nous.html.twig', [
            'controller_name' => 'InformationsController',
        ]);
    }

    /**
     * @Route("/nos-boutiques", name="informations_weStores")
     */
    public function weStores(StoreRepository $storeRepository): Response
    {
        $stores = $storeRepository->findAll();

        return $this->render('informations/nos-boutiques.html.twig', [
            "stores" => $stores,
        ]);
    }

    /**
     * @Route("/nos-marques", name="informations_weMarkets")
     */
    public function weMarkets(MarkRepository $markRepository): Response
    {
        $brands = $markRepository->findAll();

        return $this->render('informations/nos-marques.html.twig', [
            "brands" => $brands,
        ]);
    }

    /**
     * @Route("/nos-services", name="informations_weServices")
     */
    public function weServices(): Response
    {
        return $this->render('informations/nos-services.html.twig');
    }

    /**
     * @Route("/cgv", name="informations_cgv")
     */
    public function cgv(): Response
    {
        return $this->render('informations/cgv.html.twig');
    }

    /**
     * @Route("/mentions-legales", name="informations_mLegales")
     */
    public function mLegales(): Response
    {
        return $this->render('informations/mentions-legales.html.twig');
    }

    /**
     * @Route("/faq", name="informations_faq")
     */
    public function faq(): Response
    {
        return $this->render('informations/faq.html.twig');
    }

    /**
     * @Route("/guide-taille", name="informations_sizeGuide")
     */
    public function sizeGuide(): Response
    {
        return $this->render('informations/guide-taille.html.twig');
    }

    /**
     * @Route("/guide-taille-enfant", name="informations_sizeGuideChild")
     */
    public function sizeGuideChild(): Response
    {
        return $this->render('informations/guide-taille-enfant.html.twig');
    }

    /**
     * @Route("/contact", name="informations_contact")
     */
    public function contact(): Response
    {
        return $this->render('informations/contact.html.twig');
    }

    /**
     * @Route("/send", name="informations_send_email")
     */
    public function sendEmail(Request $request, MailerInterface $mailer) {
        $email = $request->query->get('email');
        $objet = $request->query->get('objet');
        $message = $request->query->get('mess');

        if ($email && $objet && $message) {
            // $this->emailVerifier->sendEmail('app_verify_email', [],(new TemplatedEmail())
            //         ->from(new Address('raul3wa@gmail.com', 'Admin Bot'))
            //         ->to($email)
            //         ->subject($objet)
            //         ->context(['message' => $message])
            //         ->htmlTemplate('registration/confirmation_email.html.twig')
            // );

            $email = (new TemplatedEmail())
                ->from(new Address('raul3wa@gmail.com', 'Admin Bot'))
                ->to($email)
                ->subject($objet)
                ->context(['message' => $message])
                ->htmlTemplate('informations/contact_email.html.twig');

            $mailer->send($email);
        }

        return $this->redirectToRoute('informations_contact');
    }
}
