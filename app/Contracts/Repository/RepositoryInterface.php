<?php

namespace App\Contracts\Repository;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 2, 2017 1:02:20 PM
 * File         : RepositoryInterface.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     :
 */
interface RepositoryInterface
{

    public function findAll();

    public function findAllWithPagination($pagination = null);

    public function findById($id);

    public function findByField($field, $value);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function persist($model);

    /**
     * @return $this
     */
    public function includeTrash();
}

/* End of file RepositoryInterface.php */