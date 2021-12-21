﻿<?php

require_once "admin/config/connect.php";
require_once "admin/functions/functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Bootshop online Shopping cart</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- include head.php -->
	<?php
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
	<div id="carouselBlk">
		<!-- include banner.php -->
		<?php
		require_once('includes/banner.php');
		?>
	</div>
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

					<!-- <div class="well well-small">
						 include featured.php
						<?php
						//require_once('includes/featured.php');
						//require_once('includes/latest.php');
						?>
					</div> -->
					<?php if (isset($_POST['submit'])) {
						//if the user has clicked submit, then show the search results
					?>
						<h3>Search Results </h3>
						<ul class="thumbnails">
							<!-- include latest.php -->
							<?php
							loadProductSearchResults($_POST);
							//advancedPostSearch($_POST);
							//getSearchResults($_POST);
							?>
						</ul>
					<?php } ?>
					<br>
					<h3>Latest Products </h3>
					<ul class="thumbnails">
						<!-- include latest.php -->
						<?php
						require_once('includes/latest.php');
						?>
					</ul>

				</div>
			</div>
		</div>
	</div>
	<!-- Footer ================================================================== -->
	<div id="footerSection">
		<?php
		require_once('includes/footer.php');
		?>
	</div>
	<!-- Placed at the end of the document so the pages load faster ============================================= -->

	<!-- include frontScripts.php -->
	<?php
	require_once('includes/frontScripts.php');
	?>


	<!-- Themes switcher section ============================================================================================= -->
	<div id="secectionBox">
		<!-- include themes.php -->
		<?php
		//require_once('includes/themes.php')
		?>
	</div>
	<span id="themesBtn"></span>

</body>

</html>