<div class="total-sales-modal" id="totalSalesModal">
  <div class="total-sales-sheet">
    
    <!-- TOPBAR -->
    <div class="total-sales-topbar">
      <button type="button" class="total-sales-close" id="closeTotalSalesModal">
        <span class="material-symbols-outlined">close</span>
      </button>

      <div class="total-sales-heading">
        <div class="total-sales-title">Revenue</div>
        <div class="total-sales-date" id="totalSalesDateLabel">Today : 26 Mar</div>
      </div>

      <button type="button" class="total-sales-share" id="openSalesExportModal" aria-label="Export">
  <span class="material-symbols-outlined">share</span>
</button>
    </div>

    <!-- TABS -->
    <div class="total-sales-tabs">
      <button class="sales-tab active" data-sales-tab="hourly">Hourly</button>
      <button class="sales-tab" data-sales-tab="weekly">Weekly</button>
      <button class="sales-tab" data-sales-tab="monthly">Monthly</button>
    </div>

    <!-- BODY -->
    <div class="total-sales-body">

      <div class="sales-chart-card">
        <div class="sales-chart-frame">

          <div class="sales-y-axis" id="salesYAxis"></div>

          <div class="sales-chart-area">
            <div class="sales-bar" id="salesBar"></div>
            <div class="sales-x-axis" id="salesXAxis"></div>
          </div>

        </div>
      </div>

      <div class="sales-summary-card">
        <div class="sales-summary-top">
          <span id="salesSummaryLabel"></span>
          <strong id="salesSummaryAmount"></strong>
        </div>

        <div class="sales-progress">
          <div class="sales-progress-bar" id="salesProgressBar"></div>
        </div>
      </div>

    </div>

    <button type="button" class="sales-filter-fab" id="openSalesSortModal" aria-label="Sort report">
  <span class="material-symbols-outlined">tune</span>
</button>

  </div>
</div>
<div class="sales-export-modal" id="salesExportModal">
  <div class="sales-export-card">
    <button type="button" class="sales-export-close" id="closeSalesExportModal" aria-label="Close">
      <span class="material-symbols-outlined">close</span>
    </button>

    <div class="sales-export-body">
      <div class="sales-export-icon-wrap">
        <div class="sales-export-icon-bg">
          <span class="material-symbols-outlined">description</span>
        </div>
      </div>

      <div class="sales-export-file-name">Report_1774511071258.pdf</div>
      <div class="sales-export-file-size">21.87 KB</div>
    </div>

    <div class="sales-export-actions">
      <button type="button" class="sales-export-text-btn">Save As</button>
      <button type="button" class="sales-export-action-btn open">Open</button>
      <button type="button" class="sales-export-action-btn share">Share</button>
    </div>
  </div>
</div>

<div class="sales-sort-modal" id="salesSortModal">
  <div class="sales-sort-sheet">
    <div class="sales-sort-topbar">
      <button type="button" class="sales-sort-icon-btn" id="closeSalesSortModal" aria-label="Close">
        <span class="material-symbols-outlined">close</span>
      </button>

      <h3>Sort</h3>

      <button type="button" class="sales-sort-icon-btn" id="applySalesSortModal" aria-label="Apply">
        <span class="material-symbols-outlined">check</span>
      </button>
    </div>

    <div class="sales-sort-body">
      <div class="sales-sort-group" id="salesSortTypeGroup">
        <button type="button" class="sales-sort-pill" data-sort-type="receipt_count">
          By receipt count
        </button>
        <button type="button" class="sales-sort-pill active" data-sort-type="total">
          By total
        </button>
      </div>

      <div class="sales-sort-group" id="salesSortOrderGroup">
        <button type="button" class="sales-sort-pill active" data-sort-order="desc">
          High to Low
        </button>
        <button type="button" class="sales-sort-pill" data-sort-order="asc">
          Low to High
        </button>
      </div>
    </div>
  </div>
</div>

{{-- =========================
   SCRIPT (ISOLATED)
========================= --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

  /* =========================
     ELEMENTS
  ========================= */
  const modal = document.getElementById("totalSalesModal");
  const closeBtn = document.getElementById("closeTotalSalesModal");
  const triggers = document.querySelectorAll(".open-total-sales-modal");
  const dateLabel = document.getElementById("totalSalesDateLabel");

  const tabs = document.querySelectorAll(".sales-tab");
  const yAxis = document.getElementById("salesYAxis");
  const xAxis = document.getElementById("salesXAxis");
  const summaryLabel = document.getElementById("salesSummaryLabel");
  const summaryAmount = document.getElementById("salesSummaryAmount");
  const progressBar = document.getElementById("salesProgressBar");
  const bar = document.getElementById("salesBar");

  const externalDate = document.getElementById("reportDateLabel");

  /* =========================
     DATA
  ========================= */
  const data = {
    hourly: {
      y: ["25.2","24.8","24.4","24.0","23.6","23.2","22.8"],
      x: ["1:00pm - 2:00pm","1:00pm - 2:00pm","1:00pm - 2:00pm"],
      label: "1:00pm - 2:00pm",
      amount: "₱ 24",
      height: "130px"
    },
    weekly: {
      y: ["25.2","24.8","24.4","24.0","23.6","23.2","22.8"],
      x: ["Thursday","Thursday","Thursday"],
      label: "Thursday",
      amount: "₱ 24",
      height: "185px"
    },
    monthly: {
      y: ["25.2","24.8","24.4","24.0","23.6","23.2","22.8"],
      x: ["March","March","March"],
      label: "March",
      amount: "₱ 24",
      height: "185px"
    }
  };

  /* =========================
     RENDER
  ========================= */
  function render(tab) {
    const d = data[tab];

    tabs.forEach(t => t.classList.toggle("active", t.dataset.salesTab === tab));

    yAxis.innerHTML = d.y.map(v => `<span>${v}</span>`).join("");
    xAxis.innerHTML = d.x.map(v => `<span>${v}</span>`).join("");

    summaryLabel.textContent = d.label;
    summaryAmount.textContent = d.amount;

    progressBar.style.width = "100%";
    progressBar.textContent = "100%";

    bar.style.height = d.height;

    if (externalDate) {
      dateLabel.textContent = externalDate.textContent;
    }
  }

  /* =========================
     OPEN / CLOSE MAIN MODAL
  ========================= */
  function openModal(){
    modal.classList.add("show");
    document.body.classList.add("no-scroll");
    render("hourly");
  }

  function closeModal(){
    modal.classList.remove("show");
    document.body.classList.remove("no-scroll");
  }

  triggers.forEach(el => el.addEventListener("click", openModal));
  closeBtn?.addEventListener("click", closeModal);

  modal?.addEventListener("click", function(e){
    if(e.target === modal) closeModal();
  });

  /* =========================
     TAB SWITCH
  ========================= */
  tabs.forEach(tab => {
    tab.addEventListener("click", function(){
      render(this.dataset.salesTab);
    });
  });

  /* =========================
     EXPORT MODAL (TUNE BUTTON)
  ========================= */
  const openSalesExportModal = document.getElementById("openSalesExportModal");
  const closeSalesExportModal = document.getElementById("closeSalesExportModal");
  const salesExportModal = document.getElementById("salesExportModal");

  function showSalesExportModal() {
    salesExportModal.classList.add("show");
  }

  function hideSalesExportModal() {
    salesExportModal.classList.remove("show");
  }

  openSalesExportModal?.addEventListener("click", function (e) {
    e.stopPropagation();
    showSalesExportModal();
  });

  closeSalesExportModal?.addEventListener("click", hideSalesExportModal);

  salesExportModal?.addEventListener("click", function (e) {
    if (e.target === salesExportModal) hideSalesExportModal();
  });

  /* =========================
     SORT MODAL (SHARE BUTTON)
  ========================= */
  const openSalesSortModal = document.getElementById("openSalesSortModal");
  const closeSalesSortModal = document.getElementById("closeSalesSortModal");
  const applySalesSortModal = document.getElementById("applySalesSortModal");
  const salesSortModal = document.getElementById("salesSortModal");

  function showSalesSortModal() {
    salesSortModal.classList.add("show");
  }

  function hideSalesSortModal() {
    salesSortModal.classList.remove("show");
  }

  openSalesSortModal?.addEventListener("click", function (e) {
    e.stopPropagation();
    showSalesSortModal();
  });

  closeSalesSortModal?.addEventListener("click", hideSalesSortModal);
  applySalesSortModal?.addEventListener("click", hideSalesSortModal);

  salesSortModal?.addEventListener("click", function (e) {
    if (e.target === salesSortModal) hideSalesSortModal();
  });

});
</script>