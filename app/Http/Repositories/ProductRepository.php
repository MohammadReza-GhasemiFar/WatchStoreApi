<?php

namespace App\Http\Repositories;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductRepository
{
    public static function get6AmazingProducts()
    {
        $products = Product::query()->where('is_special',true)
            ->orderBy('discount','DESC')->take(6)->get();
        return ProductResource::collection($products);
    }
    public static function get6MostSellerProducts()
    {
        $products = Product::query()->orderBy('sold','DESC')->take(6)->get();
        return ProductResource::collection($products);
    }
    public static function getMostSellerProducts()
    {
        $products = Product::query()->orderBy('sold','DESC')->paginate(12);
        return ProductResource::collection($products);
    }
    public static function getMostViewedProducts()
    {
        $products = Product::query()->orderBy('review','DESC')->paginate(12);
        return ProductResource::collection($products);
    }
    public static function getcheapestProducts()
    {
        $products = Product::query()->orderBy('price','ASC')->paginate(12);
        return ProductResource::collection($products);
    }
    public static function getMostExpensiveProducts()
    {
        $products = Product::query()->orderBy('price','DESC')->paginate(12);
        return ProductResource::collection($products);
    }
    public static function get6MNewestProducts()
    {
        $products = Product::query()->latest()->take(6)->get();
        return ProductResource::collection($products);
    }
    public static function getNewestProducts()
    {
        $products = Product::query()->latest()->paginate(12);
        return ProductResource::collection($products);
    }
    public static function getAllAmazingProducts()
    {
        $products = Product::query()->get();
        return ProductResource::collection($products);
    }

    public static function getProductsByCategory($id)
    {
        $products = Product::query()->where('category_id',$id)->paginate(12);
        return ProductResource::collection($products);
    }
    public static function getProductsByBrand($id)
    {
        $products = Product::query()->where('brand_id',$id)->paginate(12);
        return ProductResource::collection($products);
    }

    public static function SearchedProducts($search)
    {
        $products = Product::query()->
        where('title','like','%'.$search.'%')->
        orwhere('title_en','like','%'.$search.'%')->
        orwhere('description','like','%'.$search.'%')->
        paginate(12);
        return ProductResource::collection($products);
    }
}
