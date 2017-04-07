<?php

namespace App\Contracts\Repository;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 6, 2017 1:13:28 AM
 * File         : ItemRepositoryInterface.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     :
 */
interface ItemRepositoryInterface extends RepositoryInterface
{

    /**
     * 
     * @param integer $orderId
     */
    public function findAllAssignedItemByOrderId($orderId);

    /**
     * 
     * @param integer $orderId
     * @param integer $productId
     */
    public function findAllItemAssignedByOrderIdAndProductId($orderId, $productId);
}

/* End of file ItemRepositoryInterface.php */