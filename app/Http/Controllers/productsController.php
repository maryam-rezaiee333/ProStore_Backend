<?php

namespace App\Http\Controllers;

use App\Http\Requests\productRequest;
use App\Http\Requests\updateproductRequest;
use App\Models\products;
use Illuminate\Support\Facades\Storage;

class productsController extends Controller
{
    /**
     * GET PRODUCTS
     */
    public function index()
    {
        return products::with(['productDetails', 'images'])
            ->latest()
            ->paginate(4);
    }

    /**
     * CREATE PRODUCT
     */
    public function store(productRequest $request)
    {
        try {

            // CREATE PRODUCT
            $product = products::create([
                'name'  => $request->name,
                'stock' => $request->stock,
                'price' => $request->price,
            ]);

            // CREATE DETAILS
            $product->productDetails()->create([
                'product_id'  => $product->id,
                'brand'       => $request->brand,
                'category'    => $request->category,
                'description' => $request->description,
            ]);

            // IMAGES
            $images = [];

            if ($request->hasFile('image1')) {
                $images[] = [
                    'image_url' => $request->file('image1')
                        ->store('Product_Images', 'public'),
                ];
            }

            if ($request->hasFile('image2')) {
                $images[] = [
                    'image_url' => $request->file('image2')
                        ->store('Product_Images', 'public'),
                ];
            }

            if (!empty($images)) {
                $product->images()->createMany($images);
            }

            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product->load(['productDetails', 'images']),
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Product creation failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * SHOW PRODUCT
     */
    public function show(string $id)
    {
        return products::with(['productDetails', 'images'])
            ->findOrFail($id);
    }

    /**
     * UPDATE PRODUCT
     */
    public function update(updateproductRequest $request, string $id)
    {
        $product = products::with(['productDetails', 'images'])
            ->findOrFail($id);

        // UPDATE PRODUCT
        $product->update([
            'name'  => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
        ]);

        // UPDATE DETAILS
        $product->productDetails()->update([
            'brand'       => $request->brand,
            'category'    => $request->category,
            'description' => $request->description,
        ]);

        // NEW IMAGES
        $newImages = [];

        if ($request->hasFile('image1')) {
            $newImages[] = [
                'image_url' => $request->file('image1')
                    ->store('Product_Images', 'public'),
            ];
        }

        if ($request->hasFile('image2')) {
            $newImages[] = [
                'image_url' => $request->file('image2')
                    ->store('Product_Images', 'public'),
            ];
        }

        if (!empty($newImages)) {

            // delete old files
            foreach ($product->images as $image) {
                if (
                    $image->image_url &&
                    Storage::disk('public')->exists($image->image_url)
                ) {
                    Storage::disk('public')->delete($image->image_url);
                }
            }

            // delete old DB
            $product->images()->delete();

            // insert new
            $product->images()->createMany($newImages);
        }

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product->fresh(['productDetails', 'images']),
        ]);
    }

    /**
     * DELETE PRODUCT
     */
    public function destroy(string $id)
    {
        $product = products::with(['productDetails', 'images'])
            ->findOrFail($id);

        // DELETE IMAGES FROM STORAGE
        foreach ($product->images as $image) {
            if (
                $image->image_url &&
                Storage::disk('public')->exists($image->image_url)
            ) {
                Storage::disk('public')->delete($image->image_url);
            }
        }

        // DELETE RELATIONS
        $product->images()->delete();
        $product->productDetails()->delete();

        // DELETE PRODUCT
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    }
}