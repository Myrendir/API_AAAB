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

        if (!$userTop) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position top", implode($data['top'])), Response::HTTP_BAD_REQUEST);
        } elseif (!$userMid) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position mid", implode($data['mid'])), Response::HTTP_BAD_REQUEST);
        } elseif (!$userAdc) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position adc", implode($data['adc'])), Response::HTTP_BAD_REQUEST);
        } elseif (!$userJungle) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position jungle", implode($data['jungle'])), Response::HTTP_BAD_REQUEST);
        } elseif (!$userSupport) {
            return new JsonResponse(sprintf("The summoner name %s not exist for the position support", implode($data['support'])), Response::HTTP_BAD_REQUEST);
        }

        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        $teamManager->save($team);

        return new JsonResponse('Team created', Response::HTTP_OK);
    }
}