<footer class="pb-4">
	<div class="no-padding-mobile">
		<!-- Contenedor principal -->
		<div
			class="d-flex flex-row flex-column-reverse flex-md-row footer__container">
			<div class="container__social_links">
				<!-- Redes sociales -->
				<div class="text-center text-md-start mb-md-0">
					<img
						src="images/mangaland.svg"
						alt="Manga Land Logo"
						class="img-fluid"
						style="max-width: 300px"
						draggable="false" />
					<ul
						class="d-flex justify-content-center justify-content-md-start gap-3">
						<li>
							<a href="#"><i class="icon-facebook"></i></a>
						</li>

						<li>
							<a href="#"><i class="icon-instagram"></i></a>
						</li>
						<li>
							<a href="#"><i class="icon-youtube"></i></a>
						</li>
						<li>
							<a href="#"><i class="icon-tiktok"></i></a>
						</li>
						<li>
							<a href="#"><i class="icon-pinterest"></i></a>
						</li>
					</ul>
				</div>

				<!-- Navlinks -->
				<div class="mb-4 mb-md-0 footer__nav_links">
					<div class="mb-3">
						<h6 class="fw-bold">Manga</h6>
						<ul class="list-unstyled">
							<li>
								<a href="#" class="text-black text-decoration-none cursor-text">Josei</a>
							</li>
							<li>
								<a href="#" class="text-black text-decoration-none cursor-text">Shonen</a>
							</li>
							<li>
								<a href="#" class="text-black text-decoration-none cursor-text">Shojo</a>
							</li>
							<li>
								<a href="#" class="text-black text-decoration-none cursor-text">Seinen</a>
							</li>
							<li>
								<a href="#" class="text-black text-decoration-none cursor-text">Mahwha</a>
							</li>
							<li>
								<a href="#" class="text-black text-decoration-none cursor-text">Yaoi y Yuri</a>
							</li>
							<li>
								<a href="#" class="text-black text-decoration-none cursor-text">Otros géneros</a>
							</li>
						</ul>
					</div>
					<div>
						<ul class="list-unstyled">
							<li>
								<a href="index.php?page=aboutus" class="text-black text-decoration-none fw-bold">Contacto</a>
							</li>
							<li>
								<a href="index.php?page=aboutus" class="text-black text-decoration-none fw-bold">Sobre nosotros</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- Suscripción -->
			<div class="text-md-start suscripcion">
				<h6 class="fw-bold">Recibí las últimas ofertas</h6>
				<p>
					¿Quieres recibir nuestras ofertas? ¡Regístrate ya mismo y comenzá
					a disfrutarlas!
				</p>
				<form class="d-flex justify-content-center justify-content-md-end" method="POST" action="actions/newsletter_suscribe.php">
					<input
						type="email"
						name="email"
						class="form-control rounded-0 rounded-start w-auto suscripcion__input"
						placeholder="Email"
						required />
					<button class="btn btn-dark rounded-0 rounded-end" type="submit">
						ENVIAR
					</button>
				</form>
			</div>
		</div>

		<!-- Terminos -->
		<div class="text-center mt-4">
			<hr class="border border-dark" />
			<p class="mb-0">
				&copy; 2025 Manga Land.
				<a href="#" class="text-black text-decoration-none">Terms of Use</a>
				|
				<a href="#" class="text-black text-decoration-none">Privacy Policy</a>
			</p>
		</div>
	</div>
</footer>