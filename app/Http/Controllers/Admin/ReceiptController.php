<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Receipt;

class ReceiptController extends Controller
{
    //
    public function store(Request $request)
{
    $request->validate([
    'supplier_name' => 'required',
    'photo_one' => 'required|image',
    'photo_two' => 'required|image',
], [
    'supplier_name.required' => 'The supplier name field is required.',
    'photo_one.required' => 'Receipt photo 1 is required.',
    'photo_two.required' => 'Receipt photo 2 is required.',
]);

    $photo1 = $request->file('photo_one')->store('receipts', 'public');
    $photo2 = $request->file('photo_two')->store('receipts', 'public');

    Receipt::create([
        'supplier_name' => $request->supplier_name,
        'product_source' => $request->product_source,
        'deliver_date' => $request->deliver_date,
        'photo_one' => $photo1,
        'photo_two' => $photo2,
    ]);

    return redirect()->back()->with('success', 'Receipt saved successfully.');
}
}
