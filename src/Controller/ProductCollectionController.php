<?php

namespace App\Controller;

use App\DataProvider\ProductCollectionDataProvider;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ProductCollectionController extends AbstractController
{
    /**
     * @param ProductCollectionDataProvider $dataProvider
     * @param string $localeCode
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function __invoke(ProductCollectionDataProvider $dataProvider, string $localeCode): JsonResponse
    {
        $collection = $dataProvider->getFullPriceCollection($localeCode);
        return $this->json($collection);
    }
}
