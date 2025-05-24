<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ShowRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    use HttpResponses;

    public function index()
    {

        $products = Product::with('product_photos')
            ->with(['category' => function ($query) {
                $query->select('id', 'name');
            }])
            ->select(
                'id',
                'title',
                'description',
                'category_id',
                'price'
            )
            ->paginate()
            ->through(function ($item) {
                foreach ($item['product_photos'] as $photo) {
                    $photo['photo_url'] = $photo->product_photo_url;
                }
                return $item;
            });

        return $this->success($products);
    }

    public function store(StoreRequest $request)
    {

        DB::beginTransaction();
        try {

            $product = Product::create(
                [
                    'title' => request('title'),
                    'price' => request('price'),
                    'category_id' => request('category_id'),
                    'description' => request('description'),
                    'created_by' => Auth::id(),
                ]
            );

            $photos = request()->file('photos');
            if ($photos) {
                $this->product_photo_insert($photos, $product->id);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('ERR_PRODUCT_STORE: Store Products', [$e->getMessage()]);
            return $this->error([], 'ERR_PRODUCT_STORE', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // return response()->json($product);
        return $this->success($product);
    }

    public function show(int $id)
    {
        $product = Product::find($id);

        try {
            if (!$product) {
                return $this->error(null, 'Product not found.', Response::HTTP_NOT_FOUND);
            }

            return $this->success($product);
        } catch (Exception $e) {
            return $this->error(null, 'Server Error.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update() {}
    public function destroy(int $id)
    {

        $product = Product::find($id);

        if (!$product) {
            return $this->error(null, 'Product not found.', Response::HTTP_NOT_FOUND);
        }

        Gate::authorize('delete', $product);

        DB::beginTransaction();
        try {
            $product->deleted_by = Auth::id();
            $product->save();
            $product->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(null, 'Server Error.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->success(null, 'Product record successfully deleted');
    }

    private function product_photo_insert($photos, $product_id)
    {
        $collectFiles = [];
        $directory = "products/{$product_id}";
        foreach ($photos as $key => $photo) {
            $image_name = $photo->getClientOriginalName();

            $collectFiles[$key] = [
                'product_id' => $product_id,
                'image_name' => $image_name,
                'image_path' => $directory,


                'image_size' => $photo->getSize(),
                // 'updated_by' => Auth::id(),
            ];
            Storage::disk('public')->putFileAs($directory, new File($photo), $image_name);
        }

        ProductPhoto::insert($collectFiles);
    }
}
