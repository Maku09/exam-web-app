<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ShowRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Traits\HttpResponses;
use DateTime;
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
                'price',
                'created_by',
                'created_at'
            )
            ->orderBy('created_at', 'desc')
            ->paginate()
            ->through(function ($item) {
                foreach ($item['product_photos'] as $photo) {
                    $photo['photo_url'] = $photo->photo_url;
                }
                return $item;
            });

        return $this->success($products, 'Product retrieved successfully');
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

            $photos = $request->photos;
            $this->product_photo_insert($photos, $product->id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('ERR_PRODUCT_STORE: Store Products', [$e->getMessage()]);
            return $this->error([], 'ERR_PRODUCT_STORE', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product->load(['category', 'product_photos']);
        $product->product_photos->each->append('photo_url');

        return $this->success($product, 'Product added successfully');
    }

    public function show(int $id)
    {
        $product = Product::find($id);
        try {
            if (!$product) {
                return $this->error(null, 'Product not found.', Response::HTTP_NOT_FOUND);
            }

            $product->product_photos->each->append('photo_url');

            return $this->success($product);
        } catch (Exception $e) {
            return $this->error(null, 'Server Error.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(int $id, UpdateRequest $request)
    {
        $product = Product::find($id);

        Gate::authorize('update', $product);

        DB::beginTransaction();
        try {
            $product->title = $request->get('title');
            $product->price = $request->get('price');
            $product->category_id = $request->get('category_id');
            $product->description = $request->get('description');
            $product->updated_by = Auth::id();
            $product->updated_at = new DateTime();

            if (count($request->get('old_photos'))) {
                ProductPhoto::whereIn('id', $request->get('old_photos'))->delete();
            }

            if (count($request->get('new_photos'))) {
                $this->product_photo_insert($request->get('new_photos'), $product->id);
            }

            $product->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(null, 'Server Error.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $product->load(['category', 'product_photos']);
        $product->product_photos->each->append('photo_url');
        return $this->success($product, 'Product updated successfully.');
    }
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

        return $this->success(null, 'Product record deleted successfully');
    }

    private function product_photo_insert($photos, $product_id)
    {

        $directory = "products/{$product_id}";
        foreach ($photos as $key => $photo) {
            $data = $photo['url'];

            $base64String = substr($data, strpos($data, ',') + 1);
            $base64String = str_replace(' ', '+', $base64String);
            $imageData = base64_decode($base64String);

            if ($imageData === false) {
                throw new \Exception('Base64 decode failed');
            }

            $decodedImage = base64_decode($base64String);
            $fileSizeInBytes = strlen($decodedImage);
            $imageName = $photo['file_name'];

            $imageName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $imageName);

            $collectFiles[$key] = [
                'product_id' => $product_id,
                'image_name' => $imageName,
                'image_path' => $directory,
                'image_size' => $fileSizeInBytes,
            ];
            Storage::disk('public')->put("{$directory}/{$imageName}", $imageData);
        }

        ProductPhoto::insert($collectFiles);
    }
}
