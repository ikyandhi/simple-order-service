<?php

namespace Api\Http\Controllers\V1;

use Api\Http\Controllers\Controller;
use Api\Http\Services\ProductService;
use Api\Http\Transformers\ProductTransformer;
use App\Contracts\Repository\ProductRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Author       : Rifki Yandhi
 * Date Created : Apr 6, 2017 9:22:46 PM
 * File         : ProductController.php
 * Copyright    : rifkiyandhi@gmail.com
 * Function     : 
 */
class ProductController extends Controller
{

    /**
     *
     * @var ProductRepositoryInterface
     */
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $paginator = $this->repository->findAllWithPagination(20);

        return $this->response()->paginator($paginator, ProductTransformer::class);
    }

    /**
     * 
     * @param ProductService $service
     * @param Request $request
     * @return void
     */
    public function store(ProductService $service, Request $request)
    {
        $validation = \Validator::make($request->all(), [
                    'product'     => 'required|array',
                    'product.sku' => 'required|unique:products,sku'
        ]);

        if ($validation->fails()) {
            return $this->response()->errorBadRequest($validation->messages()->first());
        }

        $product = $service->createProduct($request);

        if ($product) {
            return $this->response()->created();
        }

        return $this->response()->errorBadRequest();
    }

    /**
     * 
     * @param integer $productId
     * @param ProductService $service
     * @param Request $request
     * @return void
     */
    public function update($productId, ProductService $service, Request $request)
    {
        $validation = \Validator::make(array_merge(['product_id' => $productId], $request->all()), [
                    'product_id'  => "required|exists:products,id",
                    'product'     => 'required|array',
                    'product.sku' => 'required'
        ]);

        if ($validation->fails()) {
            return $this->response()->errorBadRequest($validation->messages()->first());
        }

        $product = $service->updateProduct($productId, $request);

        if ($product) {
            return $this->response()->accepted();
        }
        else {
            return $this->response()->errorBadRequest("Unable to proceed the update, or product doesn't exists.");
        }
    }

    /**
     * 
     * @param integer $productId
     * @return void
     */
    public function show($productId)
    {
        $product = $this->repository->findById($productId);

        if ($product) {
            return $this->response()->item($product, ProductTransformer::class);
        }

        return $this->response()->errorNotFound();
    }

}

/* End of file ProductController.php */