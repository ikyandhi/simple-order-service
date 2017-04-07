<?php

namespace App\Contracts\Repository;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 5, 2017 1:18:41 AM
 * File         : OrderRepositoryInterface.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     :
 */
interface OrderRepositoryInterface extends RepositoryInterface
{

    public function search(array $parameters, $pagination = false);

    public function countAssignedItemsUndeliveredByOrderId($orderId);
}

/* End of file OrderRepositoryInterface.php */