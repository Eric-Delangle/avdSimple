<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Category;
use ReCaptcha\ReCaptcha;
use Cocur\Slugify\Slugify;
use App\Form\RegistrationType;
use App\Entity\AdminController;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Doctrine\Persistence\ManagerRegistry;

class SecurityController extends AbstractController
{

    private $authenticationUtils;
    private $mailer;

    public function __construct(private ManagerRegistry $doctrine ,AuthenticationUtils $authenticationUtils, MailerInterface $mailer)
    {
        $this->authenticationUtils = $authenticationUtils;
        $this->mailer = $mailer;
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(UserPasswordHasherInterface $passwordHasher,
        Request $request, EntityManagerInterface $manager)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        /* captcha */
        /*
        $recaptcha = new ReCaptcha('');
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
  
        if (!$resp->isSuccess()) {
         // $this->addFlash('N\'oubliez pas de cocher la case "Je ne suis pas un robot"');
        } else {
       */
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hash);

            // on g??n??re le token d'activation

            $user->setActivationToken(md5(uniqid()));


            $slugify = new AsciiSlugger();
            $slug = $slugify->slug($user->getFirstName() . '' . $user->getLastName());
            $user->setSlug($slug);
            $user->getCategories(new Category());
            $user->setRegisteredAt(new \DateTime());
            $user->setNiveau(1);
            $user->setUserIdentifier($user->getEmail());
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Votre compte a bien ??t?? cr????, v??rifiez vos emails pour pouvoir l\'activer.');


            // email d'activation

            $email = (new Email())
                ->from('copeauxdecouleurs@gmail.com')
                ->to($user->getEmail())

                ->subject('Activation de votre compte')
                ->text($this->renderView('emails/activation.html.twig', ['token' => $user->getActivationToken()]));


            $this->mailer->send($email);


            return $this->redirectToRoute('security_login');
        }
        // }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/activation/{token}", name="security_activation")
     */
    public function activation($token, UserRepository $userRepo)
    {
        // on verifie si un utilsateur a ce token
        $user = $userRepo->findoneBy(['activation_token' => $token]);
        dd($user);
        // si aucun utilisateur n'existe avec ce token
        if (!$user) {
            throw $this->createNotFoundException('Cet utilsateur n\'existe pas');
        }
        // on supprime le token
        $user->setActivationToken(null);
        $em = $this->doctrine->getManager();



        $em->persist($user);
        $em->flush();

        // on envoie un message flash
        $this->addFlash('message', 'Vous avez bien activ?? votre compte.');

        // on va sur l'espace membre
        return $this->redirectToRoute('member_index');
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {

        // Si le visiteur est d??j?? identifi??, on le redirige vers l'accueil
        /*
        if ($this->getSubscribedServices(['security.authorization_checker'])->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('member_index');
        }
*/
        // Le service authentication_utils permet de r??cup??rer le nom d'utilisateur
        // et l'erreur dans le cas o?? le formulaire a d??j?? ??t?? soumis mais ??tait invalide
        // (mauvais mot de passe par exemple)
       

        return $this->render('security/login.html.twig', array(
            'last_username' => $this->authenticationUtils->getLastUsername(),
            'error'         => $this->authenticationUtils->getLastAuthenticationError(),
        ));

        $this->addFlash('success', 'Vous ??tes bien connect?? !');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
        $this->addFlash('success', 'Vous ??tes bien d??connect?? !');
    }
}
