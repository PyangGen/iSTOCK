@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/home/today/receipt-preview.css') }}">
@endpush


<div class="receipt-preview-modal" id="receiptPreviewModal">
  <div class="receipt-preview-card">
    <div class="receipt-preview-topbar">
      <button type="button" class="receipt-preview-icon-btn" id="closeReceiptPreview" aria-label="Back">
        <span class="material-symbols-outlined">arrow_back</span>
      </button>

      <div class="receipt-preview-actions">
        <button type="button" class="receipt-preview-icon-btn" aria-label="Share">
          <span class="material-symbols-outlined">share</span>
        </button>
        <button type="button" class="receipt-preview-icon-btn" aria-label="SMS">
          <span class="material-symbols-outlined">sms</span>
        </button>
        <button type="button" class="receipt-preview-icon-btn" aria-label="WhatsApp">
          <span class="material-symbols-outlined">chat</span>
        </button>
        <button type="button" class="receipt-preview-icon-btn" aria-label="Download">
          <span class="material-symbols-outlined">download</span>
        </button>
        <button type="button" class="receipt-preview-icon-btn" aria-label="Print">
          <span class="material-symbols-outlined">print</span>
        </button>

        <div class="receipt-more-wrap">
          <button
            type="button"
            class="receipt-preview-icon-btn"
            id="openReceiptMoreMenu"
            aria-label="More"
          >
            <span class="material-symbols-outlined">more_vert</span>
          </button>

          <div class="receipt-more-menu" id="receiptMoreMenu">
            <button type="button" class="receipt-more-item" id="openInvoiceSettingsModal">
              Invoice Setting
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="receipt-preview-action-row">
      <button type="button" class="receipt-action-btn primary" id="openReturnConfirm">
        Return
      </button>
      <button type="button" class="receipt-action-btn danger" id="openDeleteConfirm">
        Delete
      </button>
      <button type="button" class="receipt-action-btn primary" id="openEditReceiptModal">
        Edit
      </button>
    </div>

    <div class="receipt-preview-paper">
      <div class="receipt-preview-brand">
        <h2>FYNG</h2>
        <p>+6395555225555</p>
      </div>

      <div class="receipt-preview-divider"></div>

      <div class="receipt-preview-meta">
        <div>Receipt# <span id="previewReceiptNo">-</span></div>
        <div id="previewReceiptDate">22 Mar 2026 - 11:24 AM</div>
      </div>

      <div class="receipt-preview-block">
        <div class="receipt-preview-grid head four">
          <span>P Mode</span>
          <span>I#</span>
          <span>U#</span>
          <span class="text-right">Amount</span>
        </div>
        <div class="receipt-preview-grid four">
          <span id="previewPaymentMode">Cash</span>
          <span id="previewItemKinds">0</span>
          <span id="previewUnitCount">0.0</span>
          <strong class="text-right" id="previewAmount">₱0.00</strong>
        </div>
      </div>

      <div class="receipt-preview-block">
        <div class="receipt-preview-grid head products">
          <span>Name</span>
          <span>Price</span>
          <span>Qty</span>
          <span class="text-right">Total</span>
        </div>

        <div id="previewProductsList"></div>
      </div>

      <div class="receipt-preview-summary">
        <div class="summary-row">
          <span>Subtotal</span>
          <span id="previewSubtotal">₱0.00</span>
        </div>
        <div class="summary-row grand">
          <span>Grand Total</span>
          <span id="previewGrandTotal">₱0.00</span>
        </div>
      </div>

      <div class="receipt-preview-payment">
        <div class="summary-row">
          <span>Cash Received</span>
          <span id="previewCashReceived">₱0.00</span>
        </div>
        <div class="summary-row">
          <span>Change Amount</span>
          <span id="previewChangeAmount">₱0.00</span>
        </div>
      </div>

      <div class="receipt-preview-footer">
        <p>Thank You! Visit again!</p>
        <strong>Powered By iStock</strong>
      </div>
    </div>
  </div>
</div>

<div class="return-confirm-modal" id="returnConfirmModal">
  <div class="return-confirm-card">
    <div class="return-confirm-head">
      <span class="material-symbols-outlined return-confirm-icon">delete</span>
      <h3>Are You Sure?</h3>
    </div>

    <div class="return-confirm-body">
      It will be removed from Receipt List and will be added to return archive
    </div>

    <div class="return-confirm-actions">
      <button type="button" class="return-link-btn" id="closeReturnConfirm">No</button>
      <button type="button" class="return-link-btn strong" id="confirmReturnAction">Yes, Return</button>
    </div>
  </div>
</div>

<div class="delete-confirm-modal" id="deleteConfirmModal">
  <div class="delete-confirm-card">
    <div class="delete-confirm-head">
      <span class="material-symbols-outlined delete-confirm-icon">delete</span>
      <h3>Are You Sure?</h3>
    </div>

    <div class="delete-confirm-body">
      It will be Deleted Permanently
    </div>

    <div class="delete-confirm-actions">
      <button type="button" class="delete-link-btn" id="closeDeleteConfirm">No</button>
      <button type="button" class="delete-link-btn strong" id="confirmDeleteAction">Yes, Delete</button>
    </div>
  </div>
</div>

<div class="edit-receipt-modal" id="editReceiptModal">
  <div class="edit-receipt-card">
    <div class="edit-receipt-topbar">
      <button type="button" class="edit-top-btn" id="closeEditReceiptModal" aria-label="Back">
        <span class="material-symbols-outlined">arrow_back</span>
      </button>

      <h3>Edit Receipt</h3>

      <button type="button" class="edit-save-btn">Save</button>
    </div>

    <div class="edit-receipt-body">
      <div class="edit-item-card">
        <div class="edit-item-left">
          <div class="edit-item-name">Hs</div>
          <div class="edit-item-meta"><span>1 x 12</span></div>
        </div>

        <div class="edit-item-right">
          <span class="material-symbols-outlined">edit</span>
          <strong>12</strong>
        </div>
      </div>

      <button type="button" class="edit-add-item-btn">Add Item</button>

      <div class="edit-summary-card">
        <div class="edit-summary-row">
          <span>Subtotal</span>
          <span>12</span>
        </div>

        <div class="edit-divider"></div>

        <div class="edit-summary-row grand">
          <span>Grand Total</span>
          <strong>₱12.00</strong>
        </div>

        <div class="edit-summary-links">
          <button type="button">Add Tax</button>
          <span>1 ITEMS | 1 UNITS</span>
        </div>

        <div class="edit-summary-links second">
          <button type="button">Add Discount</button>
          <button type="button">Add Other Charges</button>
        </div>
      </div>

      <div class="edit-payment-card">
        <div class="edit-payment-left">
          <span class="material-symbols-outlined">payments</span>
          <span>Cash</span>
        </div>
        <span class="material-symbols-outlined">arrow_drop_down</span>
      </div>

      <div class="edit-customer-title">Customer Details (Optional)</div>

      <div class="edit-customer-card">
        <div class="edit-phone-row">
          <div class="edit-country-code">+63</div>
          <div class="edit-phone-value">968668888</div>
        </div>

        <div class="edit-field-block">
          <label>Customer name</label>
          <div class="edit-field-value">Ddd</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="invoice-settings-modal" id="invoiceSettingsModal">
  <div class="invoice-settings-sheet">
    <div class="invoice-settings-header">
      <button type="button" class="invoice-header-btn" id="closeInvoiceSettingsModal" aria-label="Close">
        <span class="material-symbols-outlined">close</span>
      </button>

      <h3>Receipt Settings</h3>

      <button type="button" class="invoice-save-link">Save</button>
    </div>

    <div class="invoice-settings-content">
      <div class="invoice-card">
        <label class="invoice-field-label">Business Name*</label>
        <input type="text" class="invoice-field-input" value="Fyng">
      </div>

      <div class="invoice-card">
        <input type="text" class="invoice-field-input" value="+6395555225555">
        <label class="invoice-inline-check">
          <input type="checkbox" checked>
          <span>Show in Receipt</span>
        </label>
      </div>

      <div class="invoice-card">
        <label class="invoice-field-label">Business Address</label>
        <textarea class="invoice-field-textarea" rows="2"></textarea>
        <label class="invoice-inline-check">
          <input type="checkbox" checked>
          <span>Show in Receipt</span>
        </label>
      </div>

      <div class="invoice-card">
        <label class="invoice-field-label">Tax no. and Title (GSTIN:WDSD1233H:)</label>
        <input type="text" class="invoice-field-input" value="">
        <label class="invoice-inline-check">
          <input type="checkbox" checked>
          <span>Show in Receipt</span>
        </label>
      </div>

      <div class="invoice-card">
        <label class="invoice-field-label">Website</label>
        <input type="text" class="invoice-field-input" value="">
        <label class="invoice-inline-check">
          <input type="checkbox" checked>
          <span>Show in Receipt</span>
        </label>
      </div>

      <div class="invoice-card">
        <label class="invoice-field-label">Receipt title (optional)</label>
        <input type="text" class="invoice-field-input" value="** Invoice **">
      </div>

      <div class="invoice-card">
        <div class="invoice-section-title">Receipt Options</div>
        <p class="invoice-help-text">Business Logo (Preferably black and white for better printing)</p>

        <div class="invoice-upload-box">
          <button type="button" class="invoice-upload-btn" aria-label="Upload logo">
            <span class="material-symbols-outlined">add</span>
          </button>
        </div>

        <label class="invoice-inline-check beta">
          <input type="checkbox">
          <span>Show in Receipt (Beta)</span>
        </label>

        <p class="invoice-note">
          * Logo may not print properly in some printers. Please disable this option if your printer prints garbled text instead of your logo.
        </p>
      </div>

      <div class="invoice-card">
        <div class="invoice-section-title">Receipt Options</div>

        <div class="invoice-option-row">
          <div class="invoice-option-text">
            <span>Show list price (MRP/MSRP/Sticker price) in receipt (Graphical print mode only)</span>
          </div>
          <label class="invoice-switch">
            <input type="checkbox">
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-option-row">
          <div class="invoice-option-text">
            <span>Show rate in receipt</span>
          </div>
          <label class="invoice-switch">
            <input type="checkbox" checked>
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-option-row with-subtext">
          <div class="invoice-option-text">
            <span>Show total money saved by the customer</span>
            <small>Shows the total amount saved by the customer. Amount saved = list price (MRP/MSRP/Sticker price) minus the final price. Shown only when saved amount is greater than 0</small>
          </div>
          <label class="invoice-switch">
            <input type="checkbox">
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-option-row">
          <div class="invoice-option-text">
            <span>Show Cashier name on receipt?</span>
          </div>
          <label class="invoice-switch">
            <input type="checkbox">
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-option-row">
          <div class="invoice-option-text">
            <span>Show customer phone number on receipt</span>
          </div>
          <label class="invoice-switch">
            <input type="checkbox" checked>
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-option-row">
          <div class="invoice-option-text">
            <span>Show customer address on receipt</span>
          </div>
          <label class="invoice-switch">
            <input type="checkbox">
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-thankyou-block">
          <label class="invoice-field-label">Thank You Note</label>
          <input type="text" class="invoice-field-input" value="Thank You , Visit Again.">
        </div>

        <div class="invoice-option-row">
          <div class="invoice-option-text">
            <span>Use app language to share/print receipts</span>
          </div>
          <label class="invoice-switch">
            <input type="checkbox">
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-option-row">
          <div class="invoice-option-text">
            <span>Show Total Item count on receipt</span>
          </div>
          <label class="invoice-switch">
            <input type="checkbox" checked>
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-option-row">
          <div class="invoice-option-text">
            <span>Show change return amount on receipt</span>
          </div>
          <label class="invoice-switch">
            <input type="checkbox" checked>
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-option-row">
          <div class="invoice-option-text">
            <span>Show payment details on receipt</span>
          </div>
          <label class="invoice-switch">
            <input type="checkbox" checked>
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-option-row">
          <div class="invoice-option-text">
            <span>Show powered by Zobaze</span>
          </div>
          <label class="invoice-switch">
            <input type="checkbox" checked>
            <span class="invoice-switch-slider"></span>
          </label>
        </div>

        <div class="invoice-radio-group">
          <div class="invoice-radio-title">Order items by</div>
          <label class="invoice-radio-item">
            <input type="radio" name="order_items_by" checked>
            <span>Name</span>
          </label>
          <label class="invoice-radio-item">
            <input type="radio" name="order_items_by">
            <span>Order added</span>
          </label>
        </div>
      </div>

      <div class="invoice-card">
        <div class="invoice-section-title">SMS / WhatsApp / Email Template (Subject)</div>
        <label class="invoice-field-label muted">include in the message</label>
        <input type="text" class="invoice-field-input" value="Total Bill Amount is #total">
        <p class="invoice-note">is compulsory to add, #TOTAL will replace with the total amount of receipt/invoice.</p>
      </div>

      <div class="invoice-card">
        <div class="invoice-section-title">Select WhatsApp Share App</div>
        <div class="invoice-radio-group two-col">
          <label class="invoice-radio-item">
            <input type="radio" name="whatsapp_app" checked>
            <span>WhatsApp</span>
          </label>
          <label class="invoice-radio-item">
            <input type="radio" name="whatsapp_app">
            <span>WhatsApp Business</span>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const receiptPreviewModal = document.getElementById("receiptPreviewModal");
  const closeReceiptPreview = document.getElementById("closeReceiptPreview");

  const previewReceiptNo = document.getElementById("previewReceiptNo");
  const previewReceiptDate = document.getElementById("previewReceiptDate");
  const previewPaymentMode = document.getElementById("previewPaymentMode");
  const previewItemKinds = document.getElementById("previewItemKinds");
  const previewUnitCount = document.getElementById("previewUnitCount");
  const previewAmount = document.getElementById("previewAmount");
  const previewSubtotal = document.getElementById("previewSubtotal");
  const previewGrandTotal = document.getElementById("previewGrandTotal");
  const previewCashReceived = document.getElementById("previewCashReceived");
  const previewChangeAmount = document.getElementById("previewChangeAmount");
  const previewProductsList = document.getElementById("previewProductsList");

  const receiptPreviewDetails = {
    "RCPT-1001": {
      dateTime: "22 Mar 2026 - 11:24 AM",
      paymentMode: "GCash",
      cashReceived: "₱450.00",
      changeAmount: "₱0.00",
      products: [
        { name: "Hs", price: 12, qty: 1 },
        { name: "Apple", price: 12, qty: 3 }
      ]
    },
    "RCPT-1002": {
      dateTime: "22 Mar 2026 - 11:40 AM",
      paymentMode: "Cash",
      cashReceived: "₱200.00",
      changeAmount: "₱20.00",
      products: [
        { name: "Bread", price: 80, qty: 1 },
        { name: "Milk", price: 50, qty: 2 }
      ]
    },
    "RCPT-1003": {
      dateTime: "22 Mar 2026 - 12:10 PM",
      paymentMode: "Card",
      cashReceived: "₱920.00",
      changeAmount: "₱0.00",
      products: [
        { name: "Shampoo", price: 120, qty: 3 },
        { name: "Soap", price: 80, qty: 2 },
        { name: "Toothpaste", price: 200, qty: 1 }
      ]
    },
    "RCPT-1004": {
      dateTime: "22 Mar 2026 - 12:45 PM",
      paymentMode: "GCash",
      cashReceived: "₱75.00",
      changeAmount: "₱0.00",
      products: [
        { name: "Coffee", price: 75, qty: 1 }
      ]
    }
  };

  function pesoFormat(value) {
    return "₱" + Number(value).toLocaleString("en-PH", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  function openReceiptPreview(receiptNo) {
    if (!receiptPreviewModal) return;

    const details = receiptPreviewDetails[receiptNo] || {
      dateTime: "22 Mar 2026 - 11:24 AM",
      paymentMode: "Cash",
      cashReceived: "₱0.00",
      changeAmount: "₱0.00",
      products: []
    };

    previewReceiptNo.textContent = receiptNo;
    previewReceiptDate.textContent = details.dateTime;
    previewPaymentMode.textContent = details.paymentMode;
    previewProductsList.innerHTML = "";

    let kinds = details.products.length;
    let units = 0;
    let subtotal = 0;

    details.products.forEach(product => {
      const total = Number(product.price) * Number(product.qty);
      units += Number(product.qty);
      subtotal += total;

      const row = document.createElement("div");
      row.className = "receipt-preview-grid products body";
      row.innerHTML = `
        <span>${product.name}</span>
        <span>${pesoFormat(product.price)}</span>
        <span>${product.qty}</span>
        <strong class="text-right">${pesoFormat(total)}</strong>
      `;
      previewProductsList.appendChild(row);
    });

    previewItemKinds.textContent = kinds;
    previewUnitCount.textContent = units.toFixed(1);
    previewAmount.textContent = pesoFormat(subtotal);
    previewSubtotal.textContent = pesoFormat(subtotal);
    previewGrandTotal.textContent = pesoFormat(subtotal);
    previewCashReceived.textContent = details.cashReceived;
    previewChangeAmount.textContent = details.changeAmount;

    receiptPreviewModal.classList.add("show");
    document.body.classList.add("no-scroll");
  }

  function closeReceiptPreviewModal() {
    receiptPreviewModal?.classList.remove("show");
    document.body.classList.remove("no-scroll");
  }

  document.querySelectorAll(".open-receipt-preview").forEach(button => {
  button.addEventListener("click", function (e) {
    e.stopPropagation();
    openReceiptPreview(this.dataset.receipt);
  });
});

document.querySelectorAll(".open-receipt-preview-row").forEach(row => {
  row.addEventListener("click", function () {
    openReceiptPreview(this.dataset.receipt);
  });
});

  closeReceiptPreview?.addEventListener("click", closeReceiptPreviewModal);

  receiptPreviewModal?.addEventListener("click", function (e) {
    if (e.target === receiptPreviewModal) {
      closeReceiptPreviewModal();
    }
  });

  /* return */
  const openReturnConfirm = document.getElementById("openReturnConfirm");
  const returnConfirmModal = document.getElementById("returnConfirmModal");
  const closeReturnConfirm = document.getElementById("closeReturnConfirm");
  const confirmReturnAction = document.getElementById("confirmReturnAction");

  openReturnConfirm?.addEventListener("click", function (e) {
    e.stopPropagation();
    returnConfirmModal?.classList.add("show");
  });

  closeReturnConfirm?.addEventListener("click", function () {
    returnConfirmModal?.classList.remove("show");
  });

  confirmReturnAction?.addEventListener("click", function () {
    returnConfirmModal?.classList.remove("show");
    alert("Receipt moved to return archive.");
  });

  returnConfirmModal?.addEventListener("click", function (e) {
    if (e.target === returnConfirmModal) {
      returnConfirmModal.classList.remove("show");
    }
  });

  /* delete */
  const openDeleteConfirm = document.getElementById("openDeleteConfirm");
  const deleteConfirmModal = document.getElementById("deleteConfirmModal");
  const closeDeleteConfirm = document.getElementById("closeDeleteConfirm");
  const confirmDeleteAction = document.getElementById("confirmDeleteAction");

  openDeleteConfirm?.addEventListener("click", function (e) {
    e.stopPropagation();
    deleteConfirmModal?.classList.add("show");
  });

  closeDeleteConfirm?.addEventListener("click", function () {
    deleteConfirmModal?.classList.remove("show");
  });

  confirmDeleteAction?.addEventListener("click", function () {
    deleteConfirmModal?.classList.remove("show");
    alert("Receipt deleted permanently.");
  });

  deleteConfirmModal?.addEventListener("click", function (e) {
    if (e.target === deleteConfirmModal) {
      deleteConfirmModal.classList.remove("show");
    }
  });

  /* edit */
  const openEditReceiptModal = document.getElementById("openEditReceiptModal");
  const editReceiptModal = document.getElementById("editReceiptModal");
  const closeEditReceiptModal = document.getElementById("closeEditReceiptModal");

  openEditReceiptModal?.addEventListener("click", function (e) {
    e.stopPropagation();
    editReceiptModal?.classList.add("show");
    document.body.classList.add("no-scroll");
  });

  closeEditReceiptModal?.addEventListener("click", function () {
    editReceiptModal?.classList.remove("show");
    document.body.classList.remove("no-scroll");
  });

  editReceiptModal?.addEventListener("click", function (e) {
    if (e.target === editReceiptModal) {
      editReceiptModal.classList.remove("show");
      document.body.classList.remove("no-scroll");
    }
  });

  /* more menu + invoice settings */
  const openReceiptMoreMenu = document.getElementById("openReceiptMoreMenu");
  const receiptMoreMenu = document.getElementById("receiptMoreMenu");
  const openInvoiceSettingsModal = document.getElementById("openInvoiceSettingsModal");
  const invoiceSettingsModal = document.getElementById("invoiceSettingsModal");
  const closeInvoiceSettingsModal = document.getElementById("closeInvoiceSettingsModal");

  openReceiptMoreMenu?.addEventListener("click", function (e) {
    e.stopPropagation();
    receiptMoreMenu?.classList.toggle("show");
  });

  document.addEventListener("click", function (e) {
    if (
      receiptMoreMenu &&
      !receiptMoreMenu.contains(e.target) &&
      !openReceiptMoreMenu?.contains(e.target)
    ) {
      receiptMoreMenu.classList.remove("show");
    }
  });

  openInvoiceSettingsModal?.addEventListener("click", function (e) {
    e.stopPropagation();
    invoiceSettingsModal?.classList.add("show");
    receiptMoreMenu?.classList.remove("show");
  });

  closeInvoiceSettingsModal?.addEventListener("click", function () {
    invoiceSettingsModal?.classList.remove("show");
  });

  invoiceSettingsModal?.addEventListener("click", function (e) {
    if (e.target === invoiceSettingsModal) {
      invoiceSettingsModal.classList.remove("show");
    }
  });
});
</script>