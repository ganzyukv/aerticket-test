<?php
declare(strict_types=1);

namespace App\Service\Search;


use App\Repository\FlightRepository;
use DateTime;
use InvalidArgumentException;

final class FlightSearchService implements SearchServiceInterface
{
    private $repository;

    public function __construct(FlightRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search(array $query): ?array
    {
        $this->checkQuery($query);

        $query['departureDate'] = $this->getDateTimeInterval($query['departureDate']);

        return $this->repository->findBySearchQuery($query);
    }

    private function checkQuery(array $query)
    {
        if (!$this->isDate($query['departureDate'])) {
            throw new InvalidArgumentException('Parameter departure date is not correct');
        }

        $arrivalAirport = $query['arrivalAirport'] ?? null;
        $departureAirport = $query['departureAirport'] ?? null;

        if (!$arrivalAirport OR !$departureAirport) {
            throw new InvalidArgumentException('Wrong airport for search');
        }
    }

    private function isDate(string $dateString): bool
    {
        return (bool)DateTime::createFromFormat('Y-m-d', $dateString);
    }

    private function getDateTimeInterval(string $dateTime): array
    {
        $currentDateTime = new DateTime();
        $date = DateTime::createFromFormat('Y-m-d', $dateTime);

        if ($currentDateTime <= $date) {
            $date->setTime(0, 0, 0);
        }
        return [
            'start' => $date->format('Y-m-d H:i:s'),
            'end'   => $date->setTime(23, 59, 59)->format('Y-m-d H:i:s'),
        ];
    }

    public function getAll(): ?array
    {
        return $this->repository->findAll();
    }
}