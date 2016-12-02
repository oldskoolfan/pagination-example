<?php
require_once 'Pagination.php';

/**
 *	A class we will use to create fake names in our database,
 *	as well as retrieve them for display on the page.
 *	We are using Faker for name generation (https://github.com/fzaninotto/Faker)
 */
class NameSeeder {
	const LIMIT = 10;
	const NAME_GENERATE_TOTAL = 100;

	/**
	 * Faker Generator
	 *
	 * @var FakerGenerator
	 */
	private $faker;

	/**
	 * mysqli connection
	 *
	 * @var mysqli
	 */
	private $con;

	/**
	 * NameSeeder constructor
	 *
	 * @param FakerGenerator $faker Faker Generator object
	 * @param mysqli         $con   mysqli connection
	 */
	public function __construct(Faker\Generator $faker, \mysqli $con) {
		$this->faker = $faker;
		$this->con = $con;
	}

	/**
	 * seed baby_names table with some content
	 *
	 * @return void
	 */
	public function seedBabyNames() {
		$this->deleteBabyNames();
		$this->insertBabyNames();
	}

	/**
	 * get a page of names based on page and limit
	 *
	 * @param  mysqli $con 		mysqli connection
	 * @return Pagination      	object with page info
	 */
	public static function getPageOfNames(\mysqli $con) {
		// figure out where we are based on page param
		$page = $_GET['page'] ?? 1;
		$prev = $page - 1;
		$next = $page + 1;
		$limit = $_GET['limit'] ?? self::LIMIT;
		$offset = ($page - 1) * $limit;

		// get total number of name rows
		$result = $con->query('select count(*) from baby_names');
		if (!$result)
			return $this->displayMsg($con->error);

		$total = (int)$result->fetch_array()[0];

		// get our page of names
		$result = $con->query("select * from baby_names order by name
			limit $limit offset $offset");
		if ($result) {
			foreach($result as $row) {
				echo "<li>{$row['name']}</li>";
			}
			$showPrev = $prev > 0;
			$showNext = ($page * $limit) < $total;
			return new Pagination($showPrev, $showNext, $prev, $next);
		} else {
			return $this->displayMsg($con->error);
		}
	}

	/**
	 * delete all rows in baby_names table
	 *
	 * @return void
	 */
	private function deleteBabyNames() {
		$delResult = $this->con->query('delete from baby_names where id > 0');

		if (!$delResult)
			$this->displayMsg($this->con->error);
		else
			$this->displayMsg('Baby names deleted: ' . $this->con->affected_rows);
	}

	/**
	 * insert new random-generated rows into baby_names table
	 *
	 * @return void
	 */
	private function insertBabyNames() {
		$name = '';
		// good place to use a prepared statement, since we're going to do it
		// a bunch of times
		$stmt = $this->con->prepare('insert into baby_names(name) values(?)');
		$stmt->bind_param('s', $name);

		for ($i = 0; $i < self::NAME_GENERATE_TOTAL; $i++) {
			$name = $this->faker->name; // gives us a new fake name
			$success = $stmt->execute();
			if (!$success)
				$this->displayMsg($stmt->error);
		}

		// get new total in table
		$countResult = $this->con->query('select count(*) from baby_names');
		if ($countResult) {
			$count = $countResult->fetch_array()[0];
			$this->displayMsg('Baby names generated: ' . $count);
		} else {
			$this->displayMsg($stmt->error);
		}
	}

	/**
	 * wrap our displayed message in <p> tags
	 *
	 * @param  string $msg our message
	 * @return null
	 */
	private function displayMsg($msg) {
		echo '<p>' . $msg . '</p>';
		return null;
	}
}
