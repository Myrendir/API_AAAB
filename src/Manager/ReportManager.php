<?php

namespace App\Manager;

use App\Entity\Report;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Psr\Log\LoggerInterface;

class ReportManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ReportRepository
     */
    private $reportRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;

    private $serializer;

    /**
     * ReportManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param ReportRepository $reportRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ReportRepository $reportRepository,
        LoggerInterface $logger
    )
    {
        $this->em = $entityManager;
        $this->reportRepository = $reportRepository;
        $this->logger = $logger;
        $this->serializer = SerializerBuilder::create()->build();

    }

    /**
     * @return Report
     */
    public function createReport()
    {
        return new Report();
    }

    /**
     * @param $report
     * @param bool $andflush
     */
    public function save($report, $andflush = true)
    {
        $this->em->persist($report);
        if ($andflush) {
            $this->em->flush();
        }
    }
}
