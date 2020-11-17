<?php
/**
 * Created by PhpStorm
 * User: CONTE Alexandre
 * Date: 11/17/20
 * Time: 8:56 AM
 */

namespace App\Controller;

use App\Form\Entity\TournamentFormType;
use App\Manager\TournamentManager;
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
     *
     * @return JsonResponse
     */
    public function createAction(Request $request, TournamentManager $tournamentManager, ValidatorInterface $validator)
    {
        $tournament = $tournamentManager->createTournament();
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(TournamentFormType::class, $tournament);
        $form->submit($data);

        $violation = $validator->validate($tournament);

        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $tournamentManager->save($tournament);

        return new JsonResponse('Tournament created!', Response::HTTP_OK);
    }
}