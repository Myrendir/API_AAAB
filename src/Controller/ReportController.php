<?php


namespace App\Controller;

use App\Form\Entity\ReportFormType;
use App\Manager\ReportManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReportController extends AbstractController
{
    /**
     * @param Request $request
     * @param ReportManager $reportManager
     * @param ValidatorInterface $validator
     * @Route("/api/report", name="report_add", methods={"POST"})
     * @return JsonResponse
     */
    public function createReport(Request $request, ReportManager $reportManager, ValidatorInterface $validator)
    {

        $report = $reportManager->createReport();
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ReportFormType::class, $report);
        $form->submit($data);
        $violation = $validator->validate($report);
        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        $reportManager->save($report);

        return new JsonResponse('Report created.', Response::HTTP_OK);
    }

}
