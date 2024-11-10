<?php

namespace App\Service;

use App\Model\FlightEvent;
use App\Utils\DateTimeHelper;

class JourneyService
{
    private array $flightEvents;

    public function __construct()
    {
        $this->flightEvents = json_decode(file_get_contents(__DIR__ . '/../data/flightEvents.json'), true);
    }

    public function findJourneys($date, $from, $to): array
    {
        $journeys = [];

        $departureFlights = array_filter($this->flightEvents, function ($flightData) use ($date, $from) {
            $flight = new FlightEvent($flightData);
            return $flight->matchesFlightCriteria($date, $from);
        });

        foreach ($departureFlights as $firstFlightData) {
            $firstFlight = new FlightEvent($firstFlightData);

            if ($firstFlight->matchesFlightCriteria($date, $from, $to)) {
                $journeys[] = [
                    "connections" => 1,
                    "path" => [$firstFlight->toArray()]
                ];
                continue;
            }

            $connectionFlights = array_filter($this->flightEvents, function ($flightData) use ($firstFlight) {
                $flight = new FlightEvent($flightData);
                return $firstFlight->getArrivalCity() === $flight->getDepartureCity();
            });

            foreach ($connectionFlights as $secondFlightData) {
                $secondFlight = new FlightEvent($secondFlightData);

                if ($firstFlight->canConnectTo($secondFlight, $to, 4, 24)) {
                    $journeys[] = [
                        "connections" => 2,
                        "path" => [$firstFlight->toArray(), $secondFlight->toArray()]
                    ];
                }
            }
        }

        return $journeys;
    }
}
