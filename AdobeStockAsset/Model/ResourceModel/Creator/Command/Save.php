<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AdobeStockAsset\Model\ResourceModel\Creator\Command;

use Magento\Framework\App\ResourceConnection;
use Magento\AdobeStockAssetApi\Api\Data\CreatorInterface;
use Magento\AdobeStockAsset\Model\ResourceModel\Creator as CreatorResourceModel;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\EntityManager\Hydrator;

/**
 * Save multiple asset service.
 */
class Save
{
    private const ADOBE_STOCK_ASSET_CREATOR_TABLE_NAME = 'adobe_stock_creator';

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var Hydrator $hydrator
     */
    private $hydrator;

    /**
     * Save constructor.
     *
     * @param ResourceConnection $resourceConnection
     * @param Hydrator $hydrator
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        Hydrator $hydrator
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->hydrator = $hydrator;
    }

    /**
     * Multiple save creators
     *
     * @param CreatorInterface $creator
     * @return void
     */
    public function execute(CreatorInterface $creator): void
    {
        $data = $this->hydrator->extract($creator);

        $connection = $this->getConnection();
        $tableName = $this->resourceConnection->getTableName(
            self::ADOBE_STOCK_ASSET_CREATOR_TABLE_NAME
        );
        $data = $this->filterData($data, [CreatorInterface::ID, CreatorInterface::NAME]);
        if (empty($data)) {
            return;
        }
        $query = sprintf(
            'INSERT IGNORE INTO `%s` (%s) VALUES (%s)',
            $tableName,
            $this->getColumns(array_keys($data)),
            $this->getValues(count($data))
        );

        $connection->query($query, array_values($data));
    }

    /**
     * Filter data to keep only data for columns specified
     *
     * @param array $data
     * @param array $columns
     * @return array
     */
    private function filterData(array $data, array $columns)
    {
        return array_intersect_key($data, array_flip($columns));
    }

    /**
     * Retrieve DB adapter
     *
     * @return AdapterInterface
     */
    private function getConnection(): AdapterInterface
    {
        return $this->resourceConnection->getConnection();
    }

    /**
     * Get columns query part
     *
     * @param array $columns
     * @return string
     */
    private function getColumns(array $columns): string
    {
        $connection = $this->getConnection();
        $sql = implode(', ', array_map([$connection, 'quoteIdentifier'], $columns));
        return $sql;
    }

    /**
     * Get values query part
     *
     * @param int $number
     * @return string
     */
    private function getValues(int $number): string
    {
        return implode(',', array_pad([], $number, '?'));
    }
}
