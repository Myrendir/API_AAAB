<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/27/20
 * Time: 9:10 AM
 */

namespace App\Controller;

use App\Entity\Users;
use App\Form\ProfileFormType;
use App\Manager\UserManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserController
 * @package App\Controller
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 *
 * @Route("/api/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/edit", name="profile", methods={"PATCH"})
     *
     * @param UserManager $userManager
     * @param Request $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     */
    public function editProfile(UserManager $userManager, Request $request, ValidatorInterface $validator)
    {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->submit($data);
        $violation = $validator->validate($user, null, 'Profile');

        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        $userManager->save($user);

        return new JsonResponse('User Update', Response::HTTP_OK);
    }

    /**
     * @Route("/list", name="list", methods={"GET"})
     *
     * @param UserManager $userManager
     *
     * @return Response
     */
    public function getAllUsers(UserManager $userManager)
    {
        $users = $userManager->getAllUsers();
        return new Response($users);
    }

    /**
     * @Route("/get/{summonerName}", name="get_summonerName", methods={"GET"})
     *
     * @ParamConverter("users", class="App\Entity\Users")
     * @param Users $users
     * @param UserManager $userManager
     *
     * @return Response
     * @throws \Exception
     */
    public function getOneUserBySummonerName(Users $users, UserManager $userManager)
    {
        $user = $userManager->getUserBySummonerName($users->getSummonerName());
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($user, 'json', SerializationContext::create()->setGroups(['User']));
        return new Response($jsonContent);
    }
}