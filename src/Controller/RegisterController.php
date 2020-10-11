<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 9/25/20
 * Time: 3:41 PM
 */

namespace App\Controller;

use App\Form\RegisterFormType;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RegisterController
 * @package App\Controller
 *
 * @Route("/user", name="user_")
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     *
     * @param UserManager $userManager
     * @param Request $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     *
     */
    public function registerUser(UserManager $userManager, Request $request, ValidatorInterface $validator)
    {
        $user = $userManager->createUser();
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(RegisterFormType::class, $user);

        $form->submit($data);
        $violation = $validator->validate($user, null, 'Register');

        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $userManager->save($user);

        return new JsonResponse('User Created', Response::HTTP_OK);
    }
}