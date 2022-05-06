<?php

namespace App\Controller;

use App\DataProvider\ProductDataProvider;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ProductController extends AbstractController
{

    /**
     * @param ProductDataProvider $productDataProvider
     * @param string $localeCode
     * @param int $id
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function __invoke(ProductDataProvider $productDataProvider, string $localeCode, int $id): JsonResponse
    {
        $product = $productDataProvider->getFullPriceItem($id, $localeCode);
        return $this->json($product);
    }
}
