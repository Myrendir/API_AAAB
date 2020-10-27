<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 10/27/20
 * Time: 9:10 AM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 *
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/list", name="list", methods={"GET"})
     */
    public function getAllUsers()
    {

    }
}