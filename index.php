<?php
	require_once 'include/mysql.php';
	require_once 'include/NameSeeder.php';
	require_once 'include/Pagination.php';
?>
<!doctype html>
<html>
<head>
	<title>Pagination Example</title>
	<link href="assets/styles.css" rel="stylesheet">
</head>
<body>
	<main>
		<h1>Pagination Example</h1>
		<p><a href="seed_data.php">Seed Baby Names</a>&nbsp;<small>Note: This will clear the table and insert new data</small></p>
		<h2>Baby Names:</h2>
		<ul>
		<?php
		$pagination = NameSeeder::getPageOfNames($connection);
		?>
		</ul>
		<?php if ($pagination != null):?>
			<div id="page-links">
				<a href="<?="./?page=$pagination->prev"?>"
					<?=!$pagination->showPrev ? 'class="hidden"' : '' ?>>Previous</a>
				<a href="<?="./?page=$pagination->next"?>"
					<?=!$pagination->showNext ? 'class="hidden"' : '' ?>>Next</a>
			</div>
		<?php endif;?>
	</main>
</body>
</html>
