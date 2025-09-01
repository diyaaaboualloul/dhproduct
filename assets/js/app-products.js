// Fills the Add/Edit product modal
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('productModal');
  if (!modal) return;

  const modalTitle = document.getElementById('modalTitle');
  const updateId   = document.getElementById('update_id');
  const titleInput = document.getElementById('titleInput');
  const descInput  = document.getElementById('descInput');
  const priceInput = document.getElementById('priceInput');

  // Reset when opening via the "Add New Product" button
  document.querySelectorAll('[data-bs-target="#productModal"]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      if (!e.currentTarget.classList.contains('btn-edit')) {
        modalTitle.textContent = 'Add New Product';
        updateId.value = '';
        titleInput.value = '';
        descInput.value  = '';
        priceInput.value = '';
      }
    });
  });

  // Prefill when clicking an Edit button
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-edit');
    if (!btn) return;
    modalTitle.textContent = 'Edit Product';
    updateId.value   = btn.dataset.id;
    titleInput.value = btn.dataset.title || '';
    descInput.value  = btn.dataset.desc || '';
    priceInput.value = btn.dataset.price || '';
  });
});
