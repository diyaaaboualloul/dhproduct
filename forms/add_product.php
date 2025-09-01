<div class="card mb-4">
  <div class="card-header"><i class="fa-solid fa-box me-1"></i> Add / Edit Product</div>
  <div class="card-body">
    <form method="post" action="">
      <input type="hidden" name="update_id" id="update_id">

      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Title</label>
          <input type="text" class="form-control" name="title" id="titleInput" required>
        </div>
        <div class="col-md-5">
          <label class="form-label">Description</label>
          <input type="text" class="form-control" name="description" id="descInput" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Price ($)</label>
          <input type="number" class="form-control" name="price" id="priceInput"
                 step="0.01" min="0" required>
        </div>
        <div class="col-md-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>
