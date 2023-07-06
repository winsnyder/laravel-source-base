<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Presenter\BaseResponse;
use App\UseCase\Product\ProductUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    protected $service;

    public function __construct(ProductUseCase $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        //Example
        $statusCode = Response::HTTP_OK;
        $message = 'SUCCESS';
        $result = [
            'name' => 'Product 1',
        ];

        return BaseResponse::basicResponse($statusCode, $message, $result);
    }

}

?>