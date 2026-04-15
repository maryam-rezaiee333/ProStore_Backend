<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Product;
use App\Models\Product_Deltail;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $product = Product::with(['productDetails', 'images', 'reviews'])->paginate(10);
        return response()->json([
            'product'=> $product,
            'message'=> 'Success'
        ],202);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //
        $product = new Product();
        $product->create([
            'name'=> $request->name,
            'stock'=> $request->stock,
            'price'=> $request->price,
        ]);
        $product->save();

         $productDetails = new Product_Deltail();
         $productDetails->create([
            'brand'=>$request->brand,
            'description'=>$request->description,
            'category'=>$request->category,
            'product_id'=>$product->id,
         ]);
         $path = null;
         if($request->hasFile('image')){
            $path = $request->file('image')->store('Products_Images', 'public');
         }
         $image = new Image();
         $image->create([
            'image_url'=>$path,
            'imageable_id'=> $product->id,
            'imageable_type'=> Product::class,
         ]);
         $image->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return response()->json([
            'data'=> $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $request, string $id)
    {
        //
            try{
               $product = Product::findOrFail($id)->with('images','productDetails')->first();
               $product->update([
                'name'=> $request->name,
                'stock'=> $request->stock,
                'price'=> $request->price,
               ]);
               $product->save();

               $productDetail = Product_Deltail::where('product_id', $product->id)->first();
               $productDetail->update([
                 'description'=> $request->description,
                 'category'=> $request->category,
                 'brand'=> $request->brand,
               ]);
               $img_path = null;
               $img_path2 = null;
               if($request->hasFile('image1')){
                  $img_path1 = $request->file('image1')->store('Product_Images', 'public');
                   }
                   if($request->hasFile('image2')){
                      $img_path2 = $request->file('image2')->store('Product_Images', 'public');
                     }
                $images = Image::where('imageable_type', Product::class)->where('imageable', 'product_id')->get();
                for($i = 0; count($images)>0; $i++){
                    if($i == 0){
                        $images->update([
                            'image_url'=> $img_path,
                        ]);
                    }
                }
                else{

                }
                }
                   catch(Exception $error){
                return response()->json(
                    [
                        'error'=>$error->getMessage(),                    
                    ]
                );
            }
        //          if($request->user()->tokenCan('update-book')){
    //         abort('333', 'You are not allowed!');
    //     }
    //    $book->update($request->validated());

       
    //    $book->load('author');
    //    return new BookResource($book);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
