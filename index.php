<?php
include 'assets/includes/header.php';
?>
<main>
	<section>
		<div class="container" style="margin-top: 75px;">
			<div class="row d-flex justify-content-center">
				<div class="col-lg-10">
					<div class="card">
						<div class="card-body">
							<h3 class="text-center text-primary">Search Box</h3>
							<hr style="border: 1.5px solid black;">
							<form class="mt-3" method="post" action="">
								<div class="mb-3">
									<input type="text" class="form-control" id="search" placeholder="Search for.." />
									<?php echo (!empty($search_error)) ? "<span class='invalid-feedback'>$search_error</span>" : ''; ?>
								</div>
							</form>
						</div>
					</div>
					<div class="card mt-5">
						<div class="card-body">
							<div id="results"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php include 'assets/includes/footer.php'; ?>
