<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/16/20
 * Time: 9:13 AM
 */

namespace App\Controller\Admin;

use App\Form\Admin\LoginFormType;
use http\Exception\RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller\Admin
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class SecurityController extends AbstractController
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * SecurityController constructor.
     *
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/login", name="admin_security_login", methods={"GET","POST"})
     */
    public function loginAction(): Response
    {
        $form = $this->createForm(LoginFormType::class, [
            'email' => $this->authenticationUtils->getLastUsername()
        ]);

        return $this->render('admin/login.html.twig', [
            'last_username' => $this->authenticationUtils->getLastUsername(),
            'form' => $form->createView(),
            'error' => $this->authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="admin_security_logout")
     */
    public function logoutAction(): void
    {
        throw new \RuntimeException('Activate the logout in the firewall');
    }
}