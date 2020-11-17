<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/16/20
 * Time: 10:36 AM
 */

namespace App\Security\Authenticator;

use App\Form\Admin\LoginFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\AuthenticatorInterface;

/**
 * Class AdminLoginAuthenticator
 * @package App\Security\Authenticator
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class AdminLoginAuthenticator extends AbstractFormLoginAuthenticator implements AuthenticatorInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * AdminLoginAuthenticator constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param FormFactoryInterface $factory
     * @param RouterInterface $router
     */
    public function __construct(FormFactoryInterface $factory, UserPasswordEncoderInterface $passwordEncoder, RouterInterface $router)
    {
        $this->formFactory = $factory;
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        if ($request->getPathInfo() != '/login' || $request->getMethod() != 'POST') {
            return false;
        }

        return true;
    }

    public function getCredentials(Request $request)
    {
        $form = $this->formFactory->create(LoginFormType::class);
        $form->handleRequest($request);

        $data = $form->getData();
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['email']
        );

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['email']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

        return new RedirectResponse($this->router->generate('admin_security_login'));
    }

    public function getLoginUrl()
    {
        return new RedirectResponse($this->router->generate('admin_security_login'));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('sonata_admin_dashboard'));
    }
}