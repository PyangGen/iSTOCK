<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DemoSaleController extends Controller
{
    private function demoProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'Coffee',
                'price' => 199,
                'image' => 'assets/images/admin/landing/cff.jpg',
                'badge' => 'Best Seller',
                'color' => 'primary',
            ],
            [
                'id' => 2,
                'name' => 'Milk Tea',
                'price' => 149,
               'image' => 'assets/images/admin/landing/ml.jpg',
                'badge' => 'Popular',
                'color' => 'success',
            ],
            [
                'id' => 3,
                'name' => 'Candle',
                'price' => 224,
                'image' => 'assets/images/admin/landing/cd.jpg',
                'badge' => 'Lifestyle',
                'color' => 'warning',
            ],
            [
                'id' => 4,
                'name' => 'Water Bottle',
                'price' => 240,
               'image' => 'assets/images/admin/landing/wb.jpg',
                'badge' => 'New',
                'color' => 'info',
            ],
            [
                'id' => 5,
                'name' => 'Notebook',
                'price' => 89,
               'image' => 'assets/images/admin/landing/nb.jpg',
                'badge' => 'School',
                'color' => 'danger',
            ],
            [
                'id' => 6,
                'name' => 'Pens',
                'price' => 140,
                'image' => 'assets/images/admin/landing/ps.jpg',
                'badge' => 'Office',
                'color' => 'dark',
            ],
        ];
    }

    private function computeTotals(array $selectedProduct, int $qty): array
    {
        $lineTotal = $selectedProduct['price'] * $qty;
        $subtotal = $lineTotal;
        $tax = round($subtotal * 0.15);
        $discount = 10;
        $grandTotal = $subtotal + $tax - $discount;

        return compact('lineTotal', 'subtotal', 'tax', 'discount', 'grandTotal');
    }

    public function intro()
    {
        return view('admin.landing.intro');
    }

    public function products(Request $request)
    {
        $products = $this->demoProducts();
        return view('admin.landing.productsSale', compact('products'));
    }

    public function review(Request $request)
    {
        $products = collect($this->demoProducts());
        $productId = (int) $request->get('product', 1);
        $qty = max((int) $request->get('qty', 1), 1);

        $selectedProduct = $products->firstWhere('id', $productId) ?? $products->first();

        $totals = $this->computeTotals($selectedProduct, $qty);

        return view('admin.landing.review', array_merge([
            'selectedProduct' => $selectedProduct,
            'qty' => $qty,
        ], $totals));
    }

    public function payment(Request $request)
    {
        $products = collect($this->demoProducts());
        $productId = (int) $request->get('product', 1);
        $qty = max((int) $request->get('qty', 1), 1);

        $selectedProduct = $products->firstWhere('id', $productId) ?? $products->first();

        $totals = $this->computeTotals($selectedProduct, $qty);

        $paymentMethods = [
            ['name' => 'Cash', 'icon' => '💵'],
            ['name' => 'Card', 'icon' => '💳'],
            ['name' => 'GCash', 'icon' => '📱'],
            ['name' => 'Store Credit', 'icon' => '🏪'],
        ];

        return view('admin.landing.payment', array_merge([
            'selectedProduct' => $selectedProduct,
            'qty' => $qty,
            'paymentMethods' => $paymentMethods,
        ], $totals));
    }

   public function receipt(Request $request)
{
    $products = collect($this->demoProducts());
    $productId = (int) $request->get('product', 1);
    $payment = $request->get('payment', 'Cash');
    $qty = max((int) $request->get('qty', 1), 1);

    $selectedProduct = $products->firstWhere('id', $productId) ?? $products->first();

    $totals = $this->computeTotals($selectedProduct, $qty);

    $now = now();
    $invoiceNumber = 'IST-' . $now->format('Ymd-His');

    return view('admin.landing.receipt', array_merge([
        'selectedProduct' => $selectedProduct,
        'qty' => $qty,
        'payment' => $payment,
        'invoiceNumber' => $invoiceNumber,
        'receiptDateTime' => $now->toIso8601String(),
    ], $totals));
}
}