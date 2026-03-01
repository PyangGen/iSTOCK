<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\ArchivedProduct;

class ProductController extends Controller
{
    // ===============================
    // DISPLAY ALL PRODUCTS
    // ===============================
    public function index()
{
    $products = Product::with('category')
        ->orderBy('created_at', 'desc')
        ->get();

    $categories = Category::all();

    return view('admin.product.products', compact('products', 'categories'));
}
    // ===============================
    // SHOW CREATE FORM
    // ===============================
    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    // ===============================
    // STORE NEW PRODUCT
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
        'pd_name' => 'required|max:150',
    'pd_price' => 'required|numeric',
], [
    'pd_name.required' => 'The product name field is required.',
    'pd_price.required' => 'The selling price field is required.',
    'pd_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
]);

        $photoPath = null;

        if ($request->hasFile('pd_photo')) {
            $photoPath = $request->file('pd_photo')
                ->store('products', 'public');
        }

        Product::create([
            'pd_photo' => $photoPath,
            'pd_name' => $request->pd_name,
            'pd_desc' => $request->pd_desc,
            'pd_code' => $request->pd_code,
            'pd_qty' => $request->pd_qty,
            'pd_unit' => $request->pd_unit,
            'pd_cost_price' => $request->pd_cost_price,
            'pd_price' => $request->pd_price,
            'category_id' => $request->category_id,
            'pd_supplier' => $request->pd_supplier,
            'pd_expiry_date' => $request->pd_expiry_date,
            'pd_updateDate' => now(),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    // ===============================
    // EDIT FORM
    // ===============================
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.product.edit', compact('product', 'categories'));
    }

    // ===============================
    // UPDATE PRODUCT
    // ===============================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'pd_name' => 'required|max:150',
            'pd_code' => 'required|unique:products,pd_code,' . $product->pd_id . ',pd_id',
            'pd_price' => 'required|numeric',
            'pd_qty' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'pd_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('pd_photo')) {
            $photoPath = $request->file('pd_photo')
                ->store('products', 'public');
            $product->pd_photo = $photoPath;
        }

        $product->update([
            'pd_name' => $request->pd_name,
            'pd_desc' => $request->pd_desc,
            'pd_code' => $request->pd_code,
            'pd_qty' => $request->pd_qty,
            'pd_unit' => $request->pd_unit,
            'pd_cost_price' => $request->pd_cost_price,
            'pd_price' => $request->pd_price,
            'category_id' => $request->category_id,
            'pd_supplier' => $request->pd_supplier,
            'pd_expiry_date' => $request->pd_expiry_date,
            'pd_updateDate' => now(),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    // ===============================
    // DELETE PRODUCT
    // ===============================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }


    public function archive(Request $request)
{
    $product = Product::findOrFail($request->id);

    // Move product to archive
    ArchivedProduct::create([
        'pd_name' => $product->pd_name,
        'pd_code' => $product->pd_code,
        'category_id' => $product->category_id,
        'pd_qty' => $product->pd_qty,
        'pd_unit' => $product->pd_unit,
        'pd_price' => $product->pd_price,
        'pd_desc' => $product->pd_desc,
        'pd_photo' => $product->pd_photo
    ]);

    // Delete from original table
    $product->delete();

    return response()->json(['success' => true]);
}
}