<?php

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\CollectionDataProvider;
use App\Repository\LocaleRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductCollectionDataProvider extends CollectionDataProvider
{
    private LocaleRepository $localeRepository;
    private ProductRepository $productRepository;

    public function __construct(
        LocaleRepository $localeRepository,
        ProductRepository $productRepository,
        ManagerRegistry $managerRegistry,
        iterable $collectionExtensions = [])
    {
        parent::__construct($managerRegistry, $collectionExtensions);
        $this->localeRepository = $localeRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $localeCode
     * @return iterable
     * @throws NonUniqueResultException
     */
    public function getFullPriceCollection(string $localeCode): iterable
    {
        /**
         * LocaleRepository
         */
        $locale = $this->localeRepository->findOneByCode($localeCode);

        if (!$locale) {
            throw new NotFoundHttpException(
                'No locale found for this locale code'
            );
        }

        $country = $locale->getCountry();

        $products = $this->productRepository->findJoinedToVat();
        if (!$products) {
            throw new NotFoundHttpException(
                'No products found'
            );
        }

        foreach ($products as $product){
            $basePrice = $product->getPrice();
            $vats = $product->getVat();
            $productVat = null;
            foreach ($vats as $vat) {
                if ($vat->getCountry() !== $country) {
                    $productVat = $vat;
                }
            }

            if (!$productVat) {
                throw new NotFoundHttpException(
                    'No VAT found for this country'
                );
            }

            $fullPrice = floatval($basePrice + $basePrice * ($productVat->getRate()/100));
            $product->setPrice($fullPrice);
        }

        return $products;
    }
}
