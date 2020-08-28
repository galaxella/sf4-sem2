<?php

namespace App\Controller;

use App\Form\ProfilUpdateFormType;
use App\Form\PwdUpdateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilController extends AbstractController
{

    private $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
    }


    /**
     * @Route("/profil", name="profil")
     */
    public function index()
    {
        $user = $this->getUser();
        $email = $user->getEmail();
        $pseudo = $user->getPseudo();

        return $this->render('profil/index.html.twig', [
            'email' => $email,
            'pseudo' =>$pseudo,

        ]);
    }

    /**
     * Modification des données(email et pseudo) dans le profil
     *
     * @Route("/profil/upDate", name="profil_upDate")
     */
    public function profilUpdate(Request $request){
        $user = $this->getUser();
        $form = $this->createForm(ProfilUpdateFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Envoyer les données modifiées dans la bdd
            //Récuperation des données de formulaire
            $user = $form->getData();           // getData() : mèthode qui retourne les données du formulaire

            $this->manager->persist($user);
            $this->manager->flush();

            $this->addFlash('success', "Vous avez bien modifié vos données ! ");
            return $this->redirectToRoute('home');

        }

        return $this->render('profil/update.html.twig', [
            'registrationForm' => $form->createView(),
        ]);

    }

    /**
     * Modifier le mot de passe dans le profil
     *
     * @Route("/profil/password/upDate", name = "password_upDate")
     */
    public function passwordUpdate(Request $request,
                                   UserPasswordEncoderInterface $passwordEncoder){
        $user = $this->getUser();
        $form = $this->createForm(PwdUpdateFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Récuperation des données de formulaire (mot de passe)
            $password = $form->get('plainPassword')->getData();

            // hash du mot de passe et création du jeton
            $user
                ->setPassword($passwordEncoder->encodePassword($user, $password))
                ->renewToken();

            $this->manager->persist($user);
            $this->manager->flush();

            $this->addFlash('success', "Votre nouveau mot de passe a bien été enregistré ! ");
            return $this->redirectToRoute('home');
        }

        return $this->render('profil/pwd_update.html.twig', [
            'registrationForm' => $form->createView(),
        ]);

    }


}
