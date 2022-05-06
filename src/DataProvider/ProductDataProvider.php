<?php

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\ItemDataProvider;
use ApiPlatform\Core\Metadata\Property\Factory\PropertyMetadataFactoryInterface;
use ApiPlatform\Core\Metadata\Property\Factory\PropertyNameCollectionFactoryInterface;
use App\Entity\Locale;
use App\Entity\Product;
use App\Repository\LocaleRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductDataProvider extends ItemDataProvider
{

    private LocaleRepository $localeRepository;
    private ProductRepository $productRepository;

    public function __construct(
        LocaleRepository                       $localeRepository,
        ProductRepository                      $productRepository,
        ManagerRegistry                        $managerRegistry,
        PropertyNameCollectionFactoryInterface $propertyNameCollectionFactory,
        PropertyMetadataFactoryInterface       $propertyMetadataFactory,
        iterable                               $itemExtensions = []
    )
    {
        parent::__construct($managerRegistry, $propertyNameCollectionFactory, $propertyMetadataFactory, $itemExtensions);
        $this->localeRepository = $localeRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $id
     * @param string $localeCode
     * @return Product|null
     * @throws NonUniqueResultException
     */
    public function getFullPriceItem(int $id, string $localeCode): ?Product
    {
        /**
         * @var Locale
         */
        $locale = $this->localeRepository->findOneByCode($localeCode);

        if (!$locale) {
            throw new NotFoundHttpException(
                'No locale found for this locale code'
            );
        }

        $product = $this->productRepository->find($id);

        if (!$product) {
            throw new NotFoundHttpException(
                'No product found for this id'
            );
        }

        $country = $locale->getCountry();
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

        return $product;
    }
}
