<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 9/25/20
 * Time: 10:56 AM
 */

namespace App\Controller\Security;

use OpenApi\Annotations\Items;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AuthController
 * @package App\Controller\Security
 *
 * @Route("/api", name="api_")
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return JsonResponse
     *
     * @Response(
     *     response=200,
     *     description="Return a token",
     *     @Items(
     *          type="json",
     *          example="string"
     *     )
     * )
     * @Parameter(
     *     name="username",
     *     in="query",
     *     description="this field is a username f user",
     *     @Schema(type="string")
     * )
     * @Parameter(
     *     name="password",
     *     in="query",
     *     description="This field correpond at the password of user",
     *     @Schema(type="string")
     * )
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return new JsonResponse([$lastUsername, $error]);
    }

    /**
     * @Route("/login_check", name="login_check", methods={"POST"})
     *
     * @return JsonResponse
     *
     * @Response(
     *     response=200,
     *     description="Return a token"
     * )
     * @Parameter(
     *     name="username",
     *     in="query",
     *     description="this field is a username f user",
     *     @Schema(type="string")
     * )
     * @Parameter(
     *     name="password",
     *     in="query",
     *     description="This field correpond at the password of user",
     *     @Schema(type="string")
     * )
     */
    public function loginCheck()
    {
        $user = $this->getUser();

        return new JsonResponse([
            'summonerName' => $user->getSummonerName(),
            'roles' => $user->getRoles()
        ]);
    }

    /**
     * @Route("/logout", name="logout", methods={"POST"})
     */
    public function logout()
    {

    }
}