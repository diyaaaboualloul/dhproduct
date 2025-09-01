<?php
$page_title = 'Products';
require_once __DIR__ . '/includes/actions.php';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
requireAuth(); // block guests

// Fetch all products (no flash, fail silently to empty list)
$products = [];
try {
  $products = $pdo->query(
    "SELECT id, title, `desc` AS description, price
     FROM products
     ORDER BY id DESC"
  )->fetchAll();
} catch (Throwable $e) {
  $products = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include __DIR__ . '/includes/head.php'; ?>
</head>
<body class="sb-nav-fixed">
<?php include __DIR__ . '/includes/header.php'; ?>
<div id="layoutSidenav">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <div id="layoutSidenav_content">

    <main>
      <div class="container-fluid px-4">
        <h1 class="mt-4">Products</h1>
        
        <!-- Add / Edit Form -->
        <?php include __DIR__ . '/forms/add_product.php'; ?>

        <!-- Products Table -->
        <div class="card mb-4">
          <div class="card-header">
            <i class="fas fa-table me-1"></i> Product List
          </div>
          <div class="card-body">
            <table id="datatablesSimple" class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Price ($)</th>
                  <th style="width:120px">Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php if (!$products): ?>
                <tr><td colspan="5" class="text-center text-muted">No products found.</td></tr>
              <?php else: foreach ($products as $p): ?>
                <tr>
                  <td><?= (int)$p['id'] ?></td>
                  <td><?= htmlspecialchars($p['title']) ?></td>
                  <td><?= htmlspecialchars($p['description']) ?></td>
                  <td><?= number_format((float)$p['price'], 2) ?></td>
                  <td>
                    <button type="button"
                            class="btn btn-sm btn-outline-primary btn-edit"
                            data-id="<?= (int)$p['id'] ?>"
                            data-title="<?= htmlspecialchars($p['title'], ENT_QUOTES) ?>"
                            data-desc="<?= htmlspecialchars($p['description'], ENT_QUOTES) ?>"
                            data-price="<?= (float)$p['price'] ?>">
                      <i class="fa-solid fa-pen"></i>
                    </button>

                    <form method="post" action="" class="d-inline"
                          onsubmit="return confirm('Delete this product?')">
                      <!-- CSRF removed -->
                      <input type="hidden" name="delete_id" value="<?= (int)$p['id'] ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
  </div>
</div>

<?php include __DIR__ . '/includes/script.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const updateId   = document.getElementById('update_id');
  const titleInput = document.getElementById('titleInput');
  const descInput  = document.getElementById('descInput');
  const priceInput = document.getElementById('priceInput');

  // Make resetForm global so buttons in included form can call it
  window.resetForm = function() {
    if (!updateId) return;
    updateId.value = '';
    titleInput.value = '';
    descInput.value = '';
    priceInput.value = '';
  };

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-edit');
    if (!btn) return;
    updateId.value   = btn.dataset.id || '';
    titleInput.value = btn.dataset.title || '';
    descInput.value  = btn.dataset.desc || '';
    priceInput.value = btn.dataset.price || '';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
});
</script>
</body>
</html>
