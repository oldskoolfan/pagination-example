<?php
require_once 'vendor/fzaninotto/faker/src/autoload.php';
require_once 'include/mysql.php';
require_once 'include/NameSeeder.php';
?>
<!doctype html>
<html>
<head>
	<title>Pagination Example</title>
	<link href="assets/styles.css" rel="stylesheet">
</head>
<body>
	<main>
		<?php
		$faker = Faker\Factory::create();
		$seeder = new NameSeeder($faker, $connection);
		$seeder->seedBabyNames();
		?>
		<a href="./">Back</a>
	</main>
</body>
</html>
