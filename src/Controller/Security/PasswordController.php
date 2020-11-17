<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/29/20
 * Time: 11:10 AM
 */

namespace App\Controller\Security;

use App\Form\Password\ForgotPasswordFormType;
use App\Form\Password\ResetPasswordFormType;
use App\Manager\UserManager;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class PasswordController
 * @package App\Controller\Security
 *
 * @Route("/password", name="password_")
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class PasswordController extends AbstractController
{
    /**
     * @Route("/forgot", name="forgot", methods={"POST"})
     *
     * @param Request $request
     * @param UserManager $userManager
     * @param TokenGeneratorInterface $tokenGenerator
     * @param MailerInterface $mailer
     * @param UrlGeneratorInterface $urlGenerator
     *
     * @return JsonResponse
     * @throws \Exception
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function forgotPassword(Request $request, UserManager $userManager, TokenGeneratorInterface $tokenGenerator, MailerInterface $mailer, UrlGeneratorInterface $urlGenerator)
    {
        $data = json_decode($request->getContent(), true);
        $token = $tokenGenerator->generateToken();
        $url = $urlGenerator->generate('password_reset', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
        $user = $userManager->getUserByEmail($data['email']);
        $form = $this->createForm(ForgotPasswordFormType::class, $user);
        $form->submit($data);

        if (isset($user)) {
            $user->setToken($token);
            $userManager->save($user);
            $email = (new TemplatedEmail())
                ->from('noreply@api-aaab.com')
                ->to($data['email'])
                ->subject('Reinitialization Password')
                ->htmlTemplate('email/forgot_password.html.twig')
                ->context([
                    'reset_url' => $url
                ])
            ;
            $mailer->send($email);
            return new JsonResponse('Email send', Response::HTTP_OK);
        } else {
            return new JsonResponse("User not found", Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/reset/{token}", name="reset", methods={"POST"})
     *
     * @param UserManager $userManager
     * @param string $token
     * @param ValidatorInterface $validator
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function resetPassword(UserManager $userManager, string $token, Request $request, ValidatorInterface $validator)
    {
        $user = $userManager->getUserByToken($token);
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ResetPasswordFormType::class, $user);
        $form->submit($data);

        if (!isset($user)) {
            return new JsonResponse('User not found', Response::HTTP_BAD_REQUEST);
        } else {
            $violation = $validator->validate($user, null, 'Register');
            if (0 !== count($violation)) {
                foreach ($violation as $error) {
                    return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                }
            }
            $userManager->save($user);
            return new JsonResponse("Password Update");
        }
    }
}