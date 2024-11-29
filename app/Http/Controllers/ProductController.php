<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $categoryName = $request->input('category'); // Filter by Category Name
        $brandName = $request->input('brand'); // Filter by Brand Name

        $products = Product::with(['category', 'brand']);

        if ($keyword) {
            $products = $products->where('name', 'like', "%{$keyword}%");
        }

        if ($categoryName) {
            $products = $products->whereHas('category', function ($query) use ($categoryName) {
                $query->where('name', 'like', "%{$categoryName}%");
            });
        }

        if ($brandName) {
            $products = $products->whereHas('brand', function ($query) use ($brandName) {
                $query->where('name', 'like', "%{$brandName}%");
            });
        }

        $products = $products->orderBy('name', 'asc')->paginate(2);

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'image_url' => 'required|url',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'image_url.url' => 'URL gambar tidak valid.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.integer' => 'Stok harus berupa bilangan bulat.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'brand_id.required' => 'Brand wajib dipilih.',
            'brand_id.exists' => 'Brand yang dipilih tidak valid.',
        ]);

        $product = Product::create($validatedData);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'product' => $product->load('category', 'brand'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'brand'])->find($id);

        if ($product) {
            return response()->json(['product' => $product]);
        } else {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'image_url' => 'required|url',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $product->update($validatedData);

        return response()->json([
            'message' => 'Produk berhasil diupdate',
            'product' => $product->load('category', 'brand'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
