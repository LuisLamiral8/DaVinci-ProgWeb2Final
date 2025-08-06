<?php
function renderCard($cover_url, $title, $price, $class = "product_card_novedades")
{
?>
  <div class="col-6 col-md-4 col-lg-3">
    <div class="product_card <?php echo $class; ?> h-100">
      <div class="product_card__image_container text-center pb-4">
        <img src="<?php echo $cover_url; ?>" alt="<?php echo $title; ?>" class="img-fluid" draggable="false">
      </div>

      <div class="product_card__body d-flex flex-column align-items-center">
        <div class="w-100 text-center">
          <h6 class="fw-bold"><?php echo $title; ?></h6>
          <p class="text-dark fw-bold">$ <?php echo $price; ?></p>
        </div>
        <div class="d-flex justify-content-center gap-2 w-100">
          <button class="btn btn-sm btn-light">
            <i class="bi bi-cart"></i>
          </button>
          <button class="btn btn-sm btn-light">VER MÁS</button>
        </div>
      </div>
    </div>
  </div>
<?php
}
