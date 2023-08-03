<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @param Product $product
     * @return Product
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->all();

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
