<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/18/20
 * Time: 10:09 AM
 */

namespace App\Controller;

use App\Form\Entity\TeamFormType;
use App\Manager\TeamManager;
use App\Manager\UserManager;
use JMS\Serializer\SerializerBuilder;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TeamController
 * @package App\Controller
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 *
 * @Route("/api/team", name="team_")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/create", name="create", methods={"POST"})
     *
     * @param Request $request
     * @param TeamManager $teamManager
     * @param UserManager $userManager
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     *
     * @Security(name="Bearer")
     */
    public function createAction(Request $request, TeamManager $teamManager, UserManager $userManager, ValidatorInterface $validator)
    {
        $team = $teamManager->createTeam();
        $data = json_decode($request->getContent(), true);
        $userTop = $userManager->getUserBySummonerName($data["top"]);
        $userMid = $userManager->getUserBySummonerName($data["mid"]);
        $userJungle = $userManager->getUserBySummonerName($data["jungle"]);
        $userAdc = $userManager->getUserBySummonerName($data["adc"]);
        $userSupport = $userManager->getUserBySummonerName($data["support"]);
        $violation = $validator->validate($team);
        $form = $this->createForm(TeamFormType::class, $team);
        $form->submit($data);

        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        if (!$userTop && $userTop !== null) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position top", $data['top']), Response::HTTP_BAD_REQUEST);
        } elseif (!$userMid && $userMid !== null) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position mid", $data['mid']), Response::HTTP_BAD_REQUEST);
        } elseif (!$userAdc && $userAdc !== null) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position adc", $data['adc']), Response::HTTP_BAD_REQUEST);
        } elseif (!$userJungle && $userJungle !== null) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position jungle", $data['jungle']), Response::HTTP_BAD_REQUEST);
        } elseif (!$userSupport && $userSupport !== null) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position support", $data['support']), Response::HTTP_BAD_REQUEST);
        }

        $teamManager->save($team);

        return new JsonResponse('Team created', Response::HTTP_OK);
    }

    /**
     * @Route("/list", name="list", methods={"GET"})
     *
     * @param TeamManager $teamManager
     *
     * @return Response
     *
     * @Security(name="Bearer")
     */
    public function listAction(TeamManager $teamManager)
    {
        $teams = $teamManager->getAllTeams();

        return new Response($teams, Response::HTTP_OK);
    }

    /**
     * @Route("/get/{name}", name="get_team_name", methods={"GET"})
     *
     * @ParamConverter("teams", options={"name" = "name"})
     * @param $name
     * @param TeamManager $teamManager
     *
     * @return JsonResponse|Response
     *
     * @Security(name="Bearer")
     */
    public function getTeamByName($name, TeamManager $teamManager)
    {
        $team = $teamManager->getTeamByName($name);
        if (!$team) {
            return new JsonResponse(sprintf("The team with the name %s not exist", $name));
        }
        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($team, 'json');

        return new Response($jsonContent, Response::HTTP_OK);
    }

    /**
     * @Route("/update/{name}", name="update", methods={"PATCH"})
     *
     * @param $name
     * @param TeamManager $teamManager
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param UserManager $userManager
     *
     * @return JsonResponse
     *
     * @Security(name="Bearer")
     */
    public function updateAction($name, TeamManager $teamManager, Request $request, ValidatorInterface $validator, UserManager $userManager)
    {
        $team = $teamManager->getTeamByName($name);
        $data = json_decode($request->getContent(), true);
        $userTop = $userManager->getUserBySummonerName($data["top"]);
        $userMid = $userManager->getUserBySummonerName($data["mid"]);
        $userJungle = $userManager->getUserBySummonerName($data["jungle"]);
        $userAdc = $userManager->getUserBySummonerName($data["adc"]);
        $userSupport = $userManager->getUserBySummonerName($data["support"]);
        $violation = $validator->validate($team);
        $form = $this->createForm(TeamFormType::class, $team);
        $form->submit($data);

        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        if (!$userTop && $userTop !== null) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position top", $data['top']), Response::HTTP_BAD_REQUEST);
        } elseif (!$userMid && $userMid !== null) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position mid", $data['mid']), Response::HTTP_BAD_REQUEST);
        } elseif (!$userAdc && $userAdc !== null) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position adc", $data['adc']), Response::HTTP_BAD_REQUEST);
        } elseif (!$userJungle && $userJungle !== null) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position jungle", $data['jungle']), Response::HTTP_BAD_REQUEST);
        } elseif (!$userSupport && $userSupport !== null) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position support", $data['support']), Response::HTTP_BAD_REQUEST);
        }
        $teamManager->save($team);

        return new JsonResponse('Team updated', Response::HTTP_OK);
    }
}