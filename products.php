<?php

require_once "admin/config/connect.php";
require_once "admin/functions/functions.php";
?>
<?php include 'includes/cache_top.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<!-- include head.php -->
	<?php
	//loadPageMetaData('products');
	if (isset($_GET['category'])) {
		//echo loadPageMetaData('product_details', $_GET['id']);
		echo loadPageMetaTitle('products', $_GET['category']);
		echo loadPageMetaDescription('products', $_GET['category']);
		echo loadPageMetaUrl('products', $_GET['category']);
		echo loadPageMetaImage('products', $_GET['category']);
		echo loadPageMetaKeywords('products', $_GET['category']);
		echo loadPageMetaType('products', $_GET['category']);
	} else {

		echo loadPageMetaTitle('products');
		echo loadPageMetaDescription('products');
		echo loadPageMetaUrl('products');
		echo loadPageMetaImage('products');
		echo loadPageMetaKeywords('products');
		echo loadPageMetaType('products');
	}
	require_once('includes/head.php');
	?>
</head>

<body>
	<div id="header">
		<!-- include topbar.php -->
		<?php
		require_once('includes/topbar.php');
		?>
	</div>
	<!-- Header End====================================================================== -->
	<div id="mainBody">
		<div class="container">
			<div class="row">
				<!-- Sidebar ================================================== -->
				<div id="sidebar" class="span3">
					<!-- include sidebar.php -->
					<?php
					require_once('includes/sidebar.php');
					?>
				</div>
				<!-- Sidebar end=============================================== -->
				<div class="span9">
					<ul class="breadcrumb">
						<li><a href="index.php">Home</a> <span class="divider">/</span></li>
						<li class="active"><?php
											if (isset($_GET['category'])) {
												echo $_GET['category'];
											} else {
												echo 'ALL';
											} ?></li>
					</ul>
					<h3> <?php
							if (isset($_GET['category'])) {
								echo $_GET['category'];
							} else {
								echo 'ALL';
							} ?> <small class="pull-right"><?php

															if (isset($_GET['category'])) {
																echo numberOfProductsUnderCategory($_GET['category']);
															} else {
																echo getTotalNumberOfProducts();
															}
															?> available product(s)</small></h3>
					<hr class="soft" />
					<!-- <p>
						Nowadays the lingerie industry is one of the most successful business spheres.We always stay in touch with the latest fashion tendencies - that is why our goods are so popular and we have a great number of faithful customers all over the country.
					</p> -->
					<hr class="soft" />

					<!-- <form class="form-horizontal span6" action="" method="post">
						<div class="control-group">
							<label class="control-label alignL">Sort By </label>
							<select>
								<option>Priduct name A - Z</option>
								<option>Priduct name Z - A</option>
								<option>Priduct Stoke</option>
								<option>Price Lowest first</option>
							</select>
							<input type="submit" value="Sort">
						</div>

					</form> -->

					<div id="myTab" class="pull-right">
						<a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
						<a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
					</div>
					<br class="clr" />
					<br>
					<div class="tab-content">
						<!-- include products.php -->
						<?php
						require_once('includes/products.php');
						?>
					</div>

					<div class="pagination">
						<!-- include pagination.php` -->
						<?php
						//require_once('includes/pagination.php');
						?>
					</div>
					<br class="clr" />
				</div>
			</div>
		</div>
	</div>
	<!-- MainBody End ============================= -->
	<!-- Footer ================================================================== -->
	<div id="footerSection">
		<!-- include footer.php -->
		<?php
		require_once('includes/footer.php');
		?>
	</div>
	<!-- Placed at the end of the document so the pages load faster ============================================= -->

	<!-- include frontscripts.php -->
	<?php
	require_once('includes/frontScripts.php');
	?>

	<!-- Themes switcher section ============================================================================================= -->
	<div id="secectionBox">
		<!-- include themes.php -->
	</div>
	<span id="themesBtn"></span>
</body>

</html>

<?php include 'includes/cache_bottom.php'
?>