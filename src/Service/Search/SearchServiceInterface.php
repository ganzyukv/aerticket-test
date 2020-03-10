<?php
declare(strict_types=1);

namespace App\Service\Search;

use App\Entity\Flight;

interface SearchServiceInterface
{
    public function search(array $query): ?array;

    public function getAll(): ?array;
}