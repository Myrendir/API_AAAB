<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/17/20
 * Time: 8:56 AM
 */

namespace App\Controller;

use App\Form\Entity\TournamentFormType;
use App\Manager\TeamManager;
use App\Manager\TournamentManager;
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
 * Class TournamentController
 * @package App\Controller
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 *
 * @Route("/api/tournament", name="tournament_")
 */
class TournamentController extends AbstractController
{
    /**
     * @Route("/create", name="create", methods={"POST"})
     *
     * @param Request $request
     * @param TournamentManager $tournamentManager
     * @param ValidatorInterface $validator
     * @param TeamManager $teamManager
     *
     * @return JsonResponse
     *
     * @Security(name="Bearer")
     */
    public function createAction(Request $request, TournamentManager $tournamentManager, ValidatorInterface $validator, TeamManager $teamManager)
    {
        $tournament = $tournamentManager->createTournament();
        $data = json_decode($request->getContent(), true);
        $team = $teamManager->getTeamByName($data{'teams'});
        $form = $this->createForm(TournamentFormType::class, $tournament);
        $form->submit($data);
        $violation = $validator->validate($tournament);

        if (!$team) {
            return new JsonResponse(sprintf("The team %s not exist", $data['teams']),Response::HTTP_BAD_REQUEST);
        }

        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        $tournamentManager->save($tournament);

        return new JsonResponse('Tournament created', Response::HTTP_OK);
    }

    /**
     * @Route("/all", name="list", methods={"GET"})
     *
     * @param TournamentManager $tournamentManager
     *
     * @return Response
     *
     * @Security(name="Bearer")
     */
    public function listAction(TournamentManager $tournamentManager)
    {
        $tournaments = $tournamentManager->getAllTournament();

        return new Response($tournaments, Response::HTTP_OK);
    }

    /**
     * @Route("/get/{name}", name="get_tournament_name", methods={"GET"})
     *
     * @ParamConverter("tournament", options={"name" = "name"})
     * @param $name
     * @param TournamentManager $tournamentManager
     *
     * @return Response
     *
     * @Security(name="Bearer")
     */
    public function getTournamentByName($name, TournamentManager $tournamentManager)
    {
        $tournament = $tournamentManager->getTournamentByName($name);
        if (!$tournament) {
            return new JsonResponse(sprintf("The tournament with name %s not exist", $name));
        }
        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($tournament, 'json');

        return new Response($jsonContent, Response::HTTP_OK);
    }

    /**
     * @Route("/update/{name}", name="update", methods={"PATCH"})
     *
     * @ParamConverter("tournament", options={"name" = "name"})
     * @param $name
     * @param TournamentManager $tournamentManager
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param TeamManager $teamManager
     *
     * @return JsonResponse
     *
     * @Security(name="Bearer")
     */
    public function updateAction($name, TournamentManager $tournamentManager, Request $request, ValidatorInterface $validator, TeamManager $teamManager)
    {
        $tournament = $tournamentManager->getTournamentByName($name);
        if (!$tournament) {
            return new JsonResponse(sprintf("The tournament with name %s not exist", $name));
        }
        $data = json_decode($request->getContent(), true);
        $team = $teamManager->getTeamByName($data['teams']);
        $form = $this->createForm(TournamentFormType::class, $tournament);
        $form->submit($data);
        $violation = $validator->validate($tournament);

        if (!$team) {
            return new JsonResponse(sprintf("The team %s not exist", $data['teams']),Response::HTTP_BAD_REQUEST);
        }

        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $tournamentManager->save($tournament);
        return new JsonResponse('Tournament updated', Response::HTTP_OK);
    }
}