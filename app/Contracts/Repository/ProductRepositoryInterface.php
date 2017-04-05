<?php

namespace App\Contracts\Repository;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 5, 2017 8:36:04 AM
 * File         : ProductRepositoryInterface.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     :
 */
interface ProductRepositoryInterface extends RepositoryInterface
{
    
    /**
     * Check if product exists
     * 
     * @param String $sku
     */
    public function isExistsBySku($sku);
    
}

/* End of file ProductRepositoryInterface.php */