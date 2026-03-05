@extends('admin.sidebar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/product/products.css') }}">
@endpush

@section('title', 'iStock | Products')

@section('content')

    <div class="card">
    <div class="card-head">
        <div class="card-title">Product List</div>

        <div class="toolbar">
            <div class="input">
                <span>🔎</span>
                <input type="text" placeholder="Search product">
            </div>

            <button class="btn btn-success" onclick="openReceiptModal()">🧾 Receipt</button>

            <button class="btn btn-danger" onclick="openDeleteModal()">🗑 Delete Selected</button>

            <button class="btn btn-primary" onclick="openModal()">＋ Add Product</button>
        </div>
    </div>

<div class="table-wrap">
<table class="table">
    <thead>
        <tr>
            <th width="40px">
                <input type="checkbox" id="selectAll">
            </th>
            <th>Product</th>
            <th>Category</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>Price</th>
            <th>Status</th>
            <th width="80px">Edit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)

        @php
            $qty = $product->pd_qty ?? 0;

            if ($qty == 0) {
                $status = 'Out of Stock';
                $statusClass = 'badge-danger';
            } elseif ($qty <= 5) {
                $status = 'Critical';
                $statusClass = 'badge-warning';
            } elseif ($qty <= 15) {
                $status = 'Low Stock';
                $statusClass = 'badge-orange';
            } else {
                $status = 'In Stock';
                $statusClass = 'badge-success';
            }
        @endphp

        <tr class="clickable-row"
            onclick="showDetails(this)"
            data-name="{{ $product->pd_name }}"
            data-code="{{ $product->pd_code }}"
            data-category="{{ $product->category->category_name ?? '-' }}"
            data-qty="{{ $product->pd_qty ?? 0 }}"
            data-unit="{{ $product->pd_unit }}"
            data-price="₱{{ number_format($product->pd_price, 2) }}"
            data-desc="{{ $product->pd_desc ?? '-' }}"
        >
            <td onclick="event.stopPropagation();">
                <input type="checkbox"
                       class="rowCheckbox"
                       value="{{ $product->pd_id }}">
            </td>

            <td>
                <strong>{{ $product->pd_name }}</strong><br>
                <small class="text-muted">{{ $product->pd_code }}</small>
            </td>

            <td>
                <span class="badge">
                    {{ $product->category->category_name ?? '-' }}
                </span>
            </td>

            <td>{{ $qty }}</td>
            <td>{{ $product->pd_unit }}</td>
            <td>₱{{ number_format($product->pd_price, 2) }}</td>

            <td>
                <span class="badge {{ $statusClass }}">
                    {{ $status }}
                </span>
            </td>

            <td onclick="event.stopPropagation();">
                <a href="{{ route('admin.products.edit', $product->pd_id) }}"
                   class="btn btn-edit">Edit</a>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>
</div>
</div>

    {{-- RIGHT SLIDING MODAL --}}
    <div class="right-overlay" id="rightOverlay">
        <div class="right-modal" id="productModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Add Product</h3>
                    <button onclick="closeModal()">✖</button>
                </div>

                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <label>Photo</label>
                    <input type="file" name="pd_photo">
                    <label>Name</label>
                    <input type="text" name="pd_name" value="{{ old('pd_name') }}"
                        class="@error('pd_name') error-input @enderror">
                    @error('pd_name')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                    <label>Description</label>
                    <textarea name="pd_desc"></textarea>

                    <label>Code</label>
                    <input type="text" name="pd_code">

                    <label>Category</label>
                    <select name="category_id">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>



                    <label>Quantity</label>
                    <input type="number" name="pd_qty">

                    <label>Unit</label>
                    <select name="pd_unit">
                        <option value="pcs">Pieces</option>
                        <option value="box">Box</option>
                        <option value="kilo">Kilo</option>
                    </select>

                    <label>Cost Price</label>
                    <input type="number" step="0.01" name="pd_cost_price">

                    <label>Selling Price</label>
                    <input type="number" step="0.01" name="pd_price" value="{{ old('pd_price') }}"
                        class="@error('pd_price') error-input @enderror">
                    @error('pd_price')
                        <small style="color:red;">{{ $message }}</small>
                    @enderror

                    <label>Supplier</label>
                    <input type="text" name="pd_supplier">

                    <label>Expiry Date</label>
                    <input type="date" name="pd_expiry_date">

                    <button type="submit" class="btn btn-primary full-btn">Save Product</button>
                </form>
            </div>
        </div>
    </div>


    {{-- RECEIPT MODAL --}}
    <div class="center-modal" id="receiptModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Add Receipt</h3>
                <button onclick="closeReceiptModal()">✖</button>
            </div>

            <form method="POST" action="{{ route('admin.receipts.store') }}" enctype="multipart/form-data">
                @csrf

                <label>Supplier Name</label>
                <input type="text" name="supplier_name" value="{{ old('supplier_name') }}"
                    class="@error('supplier_name') error-input @enderror">

                @error('supplier_name')
                    <small style="color:red;">{{ $message }}</small>
                @enderror

                <label>Product Source</label>
                <select name="product_source">
                    <option value="Panel">Panel</option>
                    <option value="Groceries">Groceries</option>
                </select>

                <label>Delivery Date</label>
                <input type="date" name="deliver_date" class="@error('deliver_date') error-input @enderror">
                @error('deliver_date')
                    <small style="color:red;">{{ $message }}</small>
                @enderror

                <label>Receipt Photo 1</label>
                <input type="file" name="photo_one" class="@error('photo_one') error-input @enderror">

                @error('photo_one')
                    <small style="color:red;">{{ $message }}</small>
                @enderror

                <label>Receipt Photo 2</label>
                <input type="file" name="photo_two" class="@error('photo_two') error-input @enderror">

                @error('photo_two')
                    <small style="color:red;">{{ $message }}</small>
                @enderror

                <button type="submit" class="btn btn-success full-btn">
                    Save Receipt
                </button>
            </form>
        </div>
    </div>
{{-- PRODUCT DETAILS MODAL --}}
<div class="center-modal" id="detailsModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Product Details</h3>
            <button onclick="closeDetailsModal()">✖</button>
        </div>

        <div class="modal-body">
            <p><strong>Name:</strong> <span id="d_name"></span></p>
            <p><strong>Code:</strong> <span id="d_code"></span></p>
            <p><strong>Category:</strong> <span id="d_category"></span></p>
            <p><strong>Quantity:</strong> <span id="d_qty"></span></p>
            <p><strong>Unit:</strong> <span id="d_unit"></span></p>
            <p><strong>Price:</strong> <span id="d_price"></span></p>
            <p><strong>Description:</strong> <span id="d_desc"></span></p>
        </div>
    </div>
</div>

{{-- DELETE CONFIRMATION MODAL --}}
<div class="center-modal" id="deleteModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Confirm Archive</h3>
            <button onclick="closeDeleteModal()">✖</button>
        </div>
        <div class="modal-body">
            <p id="deleteMessage">
                Are you sure you want to archive selected product(s)?
            </p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger" id="confirmDeleteBtn">
                Yes, Archive
            </button>
            <button class="btn btn-secondary" onclick="closeDeleteModal()">
                Cancel
            </button>
        </div>
    </div>
</div>

{{-- WARNING MODAL --}}
<div class="center-modal" id="warningModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Notice</h3>
            <button onclick="closeWarningModal()">✖</button>
        </div>
        <div class="modal-body">
            <p id="warningMessage">
                Please select at least one product.
            </p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="closeWarningModal()">
                OK
            </button>
        </div>
    </div>
</div>

    <script>
        function openModal() {
            document.getElementById('productModal').classList.add('open');
            document.getElementById('rightOverlay').classList.add('open');
        }

        function closeModal() {
            document.getElementById('productModal').classList.remove('open');
            document.getElementById('rightOverlay').classList.remove('open');
        }
        function openReceiptModal() {
            document.getElementById('receiptModal').classList.add('open');
        }

        function closeReceiptModal() {
            document.getElementById('receiptModal').classList.remove('open');
        }

        function showDetails(row) {
    document.getElementById('d_name').innerText = row.dataset.name;
    document.getElementById('d_code').innerText = row.dataset.code;
    document.getElementById('d_category').innerText = row.dataset.category;
    document.getElementById('d_qty').innerText = row.dataset.qty;
    document.getElementById('d_unit').innerText = row.dataset.unit;
    document.getElementById('d_price').innerText = row.dataset.price;
    document.getElementById('d_desc').innerText = row.dataset.desc;

    document.getElementById('detailsModal').classList.add('open');
}

function closeDetailsModal() {
    document.getElementById('detailsModal').classList.remove('open');
}




// ==========================
// SELECT ALL
// ==========================
document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.rowCheckbox')
        .forEach(cb => cb.checked = this.checked);
});

// ==========================
// OPEN DELETE MODAL
// ==========================
function openDeleteModal() {
    let selected = document.querySelectorAll('.rowCheckbox:checked');

    if (selected.length === 0) {
    openWarningModal("Please select at least one product.");
    return;
}
    document.getElementById('deleteMessage')
        .innerText = `Are you sure you want to archive ${selected.length} selected product(s)?`;

    document.getElementById('deleteModal').classList.add('open');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
}

function openWarningModal(message) {
    document.getElementById('warningMessage').innerText = message;
    document.getElementById('warningModal').classList.add('open');
}

function closeWarningModal() {
    document.getElementById('warningModal').classList.remove('open');
}
// ==========================
// CONFIRM ARCHIVE (BULK)
// ==========================
document.getElementById('confirmDeleteBtn')
.addEventListener('click', function() {

    let selected = document.querySelectorAll('.rowCheckbox:checked');
    let ids = [];

    selected.forEach(cb => ids.push(cb.value));

    fetch("{{ route('admin.products.archive') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ ids: ids })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeDeleteModal();
            location.reload();
        }
    });

});
    </script>
  {{-- Open Product Modal Only If Product Has Errors --}}
@if ($errors->has('pd_name') || $errors->has('pd_price'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        openModal();
    });
</script>
@endif


{{-- Open Receipt Modal Only If Receipt Has Errors --}}
@if (
    $errors->has('supplier_name') ||
    $errors->has('product_source') ||
    $errors->has('deliver_date') ||
    $errors->has('photo_one') ||
    $errors->has('photo_two')
)
<script>
    document.addEventListener("DOMContentLoaded", function() {
        openReceiptModal();
    });
</script>
@endif
@endsection