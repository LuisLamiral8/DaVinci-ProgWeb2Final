<?php
require_once "class/mysqli.php";
require_once "components/card.php";
require_once "class/Product.php";
session_start();


$err = false;
$limit = 4;
$currentPage = isset($_GET['currentPage']) ? max(1, intval($_GET['currentPage'])) : 1;
$offset = ($currentPage - 1) * $limit;

try {
	$ddbb = new MySQLDB();
	$connection = $ddbb->getConnection();

	$totalPages = (new Product())->countPages($connection, $limit);
	$productsPaginated = (new Product())->findPageAll($connection, $limit, $offset);
	$bestSellersProductsPaginated = (new Product())->findPageAll($connection, 10, 0, true);
} catch (Exception $error) {
	$err = true;
}


$newsLetterStatus = $_SESSION['newsletter_status'] ?? '';
$newsletterErrors = $_SESSION['newsletter_errors'] ?? [];
$newsletterType = $_SESSION['newsletter_type'] ?? '';
if ($newsLetterStatus) {
	unset($_SESSION['newsletter_status']);
}
?>
<link rel="stylesheet" href="styles/home.css">

<?php if ($newsLetterStatus || !empty($newsletterErrors)): ?>
  <div class="alert alert-<?= htmlspecialchars($newsletterType) ?> alert-dismissible fade show mb-4" role="alert">
    <?php if ($newsLetterStatus): ?>
      <?= $newsLetterStatus ?><br>
    <?php endif; ?>
    <?php if (!empty($newsletterErrors)): ?>
      <ul class="mb-0">
        <?php foreach ($newsletterErrors as $err): ?>
          <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
      </ul>
      <?php unset($_SESSION['newsletter_errors']); ?>
    <?php endif; ?>
  </div>
<?php endif; ?>


<!-- //?Slider -->
<div id="mainCarousel" class="carousel slide mb-4 pb-5 pointer-event" data-bs-ride="carousel">
	<div class="carousel-inner">
		<div class="carousel-item">
			<img src="images/banner.jpg" class="d-block w-100" alt="Novedades" draggable="false">
		</div>
		<div class="carousel-item active">
			<img src="images/banner.jpg" class="d-block w-100" alt="Ofertas" draggable="false">
		</div>
	</div>
	<button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
	</button>
	<button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
	</button>
</div>

<!-- //?Beneficios -->
<section class="mb-4">
	<div class="container">
		<div class="row text-center text-md-start g-4">
			<!-- Tarjeta 1 -->
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="card shadow-sm h-100 custom_border">
					<div class="card-body d-flex">
						<img src="images/icons/icon_credit.svg" alt="3 cuotas sin interés" class="me-3" style="width: 50px; align-self: flex-start" draggable="false">
						<div>
							<h6 class="fw-bold mb-1">3 CUOTAS SIN INTERÉS</h6>
							<p class="text-muted mb-0">
								Aboná en 3 cuotas sin interés con tu tarjeta de crédito.
							</p>
						</div>
					</div>
				</div>
			</div>
			<!-- Tarjeta 2 -->
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="card custom_border shadow-sm h-100">
					<div class="card-body d-flex">
						<img src="images/icons/icon_discount.svg" alt="Ofertas increíbles" class="me-3" style="width: 50px; align-self: flex-start" draggable="false">
						<div>
							<h6 class="fw-bold mb-1">OFERTAS INCREÍBLES</h6>
							<p class="text-muted mb-0">
								15% de descuento con transferencia y promociones únicas.
							</p>
						</div>
					</div>
				</div>
			</div>
			<!-- Tarjeta 3 -->
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="card custom_border shadow-sm h-100">
					<div class="card-body d-flex">
						<img src="images/icons/icon_fast.svg" alt="Envíos a todo el país" class="me-3" style="width: 50px; align-self: flex-start" draggable="false">
						<div>
							<h6 class="fw-bold mb-1">ENVÍOS A TODO EL PAÍS</h6>
							<p class="text-muted mb-0">
								Correo argentino y Andreani. Para envíos al exterior: Vía
								Courier Fedex, UPS.
							</p>
						</div>
					</div>
				</div>
			</div>
			<!-- Tarjeta 4 -->
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="card custom_border shadow-sm h-100">
					<div class="card-body d-flex">
						<img src="images/icons/icon_preventa.svg" alt="Preventas con descuento" class="me-3" style="width: 50px; align-self: flex-start" draggable="false">
						<div>
							<h6 class="fw-bold mb-1">PREVENTAS CON DESCUENTO</h6>
							<p class="text-muted mb-0">Clickea acá para acceder.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php if (!$err) { ?>
	<!-- //?Novedades-->
	<section id="novedades-section">
		<div class="container">
			<div class="section-title section-title_novedades mb-5">
				<h2 class="text-center fw-bold">Novedades</h2>
			</div>
			<div class="row g-4" id="novedades-content">
				<?php
				foreach ($productsPaginated as $product) {
					renderCard(
						$product->cover_url,
						$product->title,
						$product->price,
						"product_card_novedades"
					);
				}
				?>
			</div>
		</div>
	</section>

	<nav aria-label="Pagination Navigation" class="d-flex justify-content-center my-4">
		<ul class="pagination mb-0">
			<li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
				<a class="page-link" href="?currentPage=<?= max(1, $currentPage - 1) ?>#novedades-section" aria-label="Previous" tabindex="<?= $currentPage <= 1 ? '-1' : '0' ?>">
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
			<?php for ($i = 1; $i <= $totalPages; $i++) { ?>
				<li class="page-item <?= $currentPage == $i ? 'active' : '' ?>">
					<a class="page-link" href="?currentPage=<?= $i ?>#novedades-section" <?= $currentPage == $i ? 'aria-current="page"' : '' ?>><?= $i ?></a>
				</li>
			<?php } ?>
			<li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
				<a class="page-link" href="?currentPage=<?= min($totalPages, $currentPage + 1) ?>#novedades-section" aria-label="Next" tabindex="<?= $currentPage >= $totalPages ? '-1' : '0' ?>">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
		</ul>
	</nav>

	<!-- //?Best Sellers -->
	<section>
		<div class="container">
			<div class="section-title section-title_ofertas mb-5">
				<h2 class="text-center fw-bold">Mas vendidos</h2>
			</div>
			<div class="row g-4">
				<?php
				foreach ($bestSellersProductsPaginated as $product) {
					renderCard(
						$product->cover_url,
						$product->title,
						$product->price,
						"product_card_ofertas"
					);
				}
				?>
			</div>
		</div>
	</section>
<?php } else { ?>
	<div class="container my-5">
		<div class="alert alert-danger d-flex align-items-center" role="alert">
			<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Error:">
				<use xlink:href="#exclamation-triangle-fill" />
			</svg>
			<div>
				<h4 class="alert-heading mb-1">Error al traer los productos</h4>
				<p class="mb-0">Ocurrió un problema al cargar los productos. Por favor, intente nuevamente más tarde.</p>
			</div>
		</div>
		<div class="d-flex justify-content-center my-4">
			<div class="spinner-border text-danger" role="status">
				<span class="visually-hidden">Cargando...</span>
			</div>
		</div>
	</div>
	<!-- SVG icon for alert (Bootstrap 5) -->
	<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
		<symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
			<path d="M8.982 1.566a1.13 1.13 0 0 0-1.964 0L.165 13.233c-.457.778.091 1.767.982 1.767h13.707c.89 0 1.438-.99.982-1.767L8.982 1.566zm-.982 4.905a.905.905 0 1 1 1.81 0l-.35 3.507a.552.552 0 0 1-1.11 0L8 6.47zm.002 6.002a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
		</symbol>
	</svg>
<?php } ?>
<!-- //!Fin de productos -->

<?php include_once "components/sponsor.php" ?>