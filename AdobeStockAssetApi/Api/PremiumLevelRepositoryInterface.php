<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\AdobeStockAssetApi\Api;

use Magento\AdobeStockAssetApi\Api\Data\PremiumLevelInterface;
use Magento\AdobeStockAssetApi\Api\Data\PremiumLevelSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface PremiumLevelRepositoryInterface
 * @api
 */
interface PremiumLevelRepositoryInterface
{
    /**
     * Save asset category
     *
     * @param \Magento\AdobeStockAssetApi\Api\Data\PremiumLevelInterface $item
     * @return \Magento\AdobeStockAssetApi\Api\Data\PremiumLevelInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(PremiumLevelInterface $item): PremiumLevelInterface;

    /**
     * Delete item
     *
     * @param PremiumLevelInterface $item
     * @return void
     * @throws \Exception
     */
    public function delete(PremiumLevelInterface $item): void;

    /**
     * Get a list of categories
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\AdobeStockAssetApi\Api\Data\PremiumLevelSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): PremiumLevelSearchResultsInterface;

    /**
     * Get asset category by id
     *
     * @param int $id
     * @return \Magento\AdobeStockAssetApi\Api\Data\PremiumLevelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id) : PremiumLevelInterface;

    /**
     * Delete premium level id
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function deleteById(int $id): void;
}
