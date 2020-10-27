<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/27/20
 * Time: 9:10 AM
 */

namespace App\Controller;

use App\Entity\Users;
use App\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return new Response($user);
    }
}