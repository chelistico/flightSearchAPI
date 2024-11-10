<?php

namespace App\Controller;

use App\Service\JourneyService;

class JourneyController
{
    private JourneyService $journeyService;

    public function __construct(JourneyService $journeyService)
    {
        $this->journeyService = $journeyService;
    }

    public function searchJourneys($date, $from, $to)
    {
        $journeys = $this->journeyService->findJourneys($date, $from, $to);
        header('Content-Type: application/json');
        echo json_encode($journeys);
    }
}
