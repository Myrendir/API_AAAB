<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/29/20
 * Time: 11:10 AM
 */

namespace App\Controller\Security;

use App\Form\ForgotPasswordFormType;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

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
     * @param Mailer $mailer
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function forgotPassword(Request $request, UserManager $userManager, TokenGeneratorInterface $tokenGenerator, Mailer $mailer)
    {
        $data = json_decode($request->getContent(), true);
        $user = $userManager->getByEmail($data['email']);
        $form = $this->createForm(ForgotPasswordFormType::class, $user);
        $form->submit($data);

        if (isset($user)) {
            $token = $tokenGenerator->generateToken();
            $user->setToken($token);
            $userManager->save($user);
        } else {
            return new JsonResponse("User not found", Response::HTTP_BAD_REQUEST);
        }
    }
}