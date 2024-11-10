<?php

namespace App\Model;

use DateTime;
use App\Utils\DateTimeHelper;

class FlightEvent
{
    private string $flightNumber;
    private string $departureCity;
    private string $arrivalCity;
    private DateTime $departureTime;
    private DateTime $arrivalTime;

    public function __construct(array $data)
    {
        $this->flightNumber = $data['flight_number'];
        $this->departureCity = $data['departure_city'];
        $this->arrivalCity = $data['arrival_city'];
        $this->departureTime = new DateTime($data['departure_time']);
        $this->arrivalTime = new DateTime($data['arrival_time']);
    }

    public function getDepartureCity(): string
    {
        return $this->departureCity;
    }


    public function getArrivalCity(): string
    {
        return $this->arrivalCity;
    }

    public function matchesFlightCriteria($date, $from, $to = null, $exactDestination = true): bool
    {
        $matchesDate = $this->departureTime->format('Y-m-d') === $date;
        $matchesFrom = $this->departureCity === $from;
        $matchesTo = $exactDestination ? ($this->arrivalCity === $to) : ($this->arrivalCity !== $to);
    
        return $matchesDate && $matchesFrom && ($to === null || $matchesTo);
    }
    

    public function canConnectTo(self $nextFlight, $finalDestination, $maxConnectionTime, $maxTotalDuration): bool
    {
        $connectionTime = DateTimeHelper::getDifferenceInHours($this->arrivalTime, $nextFlight->departureTime);
        $totalDuration = DateTimeHelper::getDifferenceInHours($this->departureTime, $nextFlight->arrivalTime);
        
        return $this->arrivalCity === $nextFlight->departureCity &&
               $nextFlight->arrivalCity === $finalDestination &&
               $connectionTime <= $maxConnectionTime && $totalDuration <= $maxTotalDuration;
    }

    public function toArray(): array
    {
        return [
            "flight_number" => $this->flightNumber,
            "from" => $this->departureCity,
            "to" => $this->arrivalCity,
            "departure_time" => $this->departureTime->format('Y-m-d H:i'),
            "arrival_time" => $this->arrivalTime->format('Y-m-d H:i')
        ];
    }
}
