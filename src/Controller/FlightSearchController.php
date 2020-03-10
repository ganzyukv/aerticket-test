<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\Search\SearchServiceInterface;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

final class FlightSearchController extends AbstractFOSRestController
{
    /**
     * @Post("/search")
     * @param Request $request
     * @param SearchServiceInterface $searchService
     * @return View
     * @throws EntityNotFoundException
     * @throws InvalidArgumentException
     */
    public function searchAction(Request $request, SearchServiceInterface $searchService): View
    {
        $searchQuery = $request->get('searchQuery');

        if (!$searchQuery) {
            throw new InvalidArgumentException('Empty parameters for search flights');
        }

        $result = $searchService->search($searchQuery);

        if (!$result) {
            throw new EntityNotFoundException('Flight by search query does not found!');
        }

        return $this->view($result);

    }

    /**
     * @Get("/search")
     * @param SearchServiceInterface $searchService
     * @return View
     * @throws EntityNotFoundException
     */
    public function getAllFlightsAction(SearchServiceInterface $searchService): View
    {
        $result = $searchService->getAll();

        if (!$result) {
            throw new EntityNotFoundException('Flight does not found!');
        }

        return $this->view($result);

    }


}