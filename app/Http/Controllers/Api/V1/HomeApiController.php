<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ProductRepository;
use App\Http\services\Keys;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/v1/home",
     *  tags={"Home Page"},
     *  description="get home page data",
     *   @OA\Response(
     *      response=200,
     *      description="Its Ok",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function Home()
    {
        return response()->json([
            'result' => true,
            'message' => 'Application Home Page',
            'date' => [
                Keys::sliders => Slider::getSliders(),
                Keys::categories => Category::getAllCategories(),
                Keys::amazing_products =>ProductRepository::get6AmazingProducts(),
                Keys::banner =>Slider::query()->inRandomOrder()->first(),
                Keys::most_seller_products =>ProductRepository::get6MostSellerProducts(),
                Keys::newest_products =>ProductRepository::get6MNewestProducts(),

            ]

        ],200);
    }
}
