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
        'product_source' => 'required',
        'deliver_date' => 'required|date', // ✅ ADD THIS
        'photo_one' => 'required|image',
        'photo_two' => 'required|image',
    ], [
        'supplier_name.required' => 'The supplier name field is required.',
        'product_source.required' => 'The product source field is required.',
        'deliver_date.required' => 'The delivery date field is required.', // ✅ ADD MESSAGE
        'deliver_date.date' => 'Please enter a valid delivery date.',
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
