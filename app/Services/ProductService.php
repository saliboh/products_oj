<?php

namespace App\Services;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductService
{
    /**
     * @param $data
     * @return Product
     */
    public function store($request): Product
    {
        $data = $request->validated();
        $photoPath = '';
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('product_photos', 'public');
        }

        $data['photo'] = $photoPath;

        $product = new Product($data);
        $product->save();

        return $product;
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return Product
     */
    public function update($request, Product $product): Product
    {
        $data = $request->all();
        dd($data);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('product_photos', 'public');
            $data['photo'] = $photoPath;

            // Delete old photo if exists
            Storage::disk('public')->delete($product->photo);
        }

        $product->update($data);

        return $product;
    }
}
