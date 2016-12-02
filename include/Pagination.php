<?php

/**
 * 	A simple class to carry page info so we can build our prev/next links
 */
class Pagination {
	/** @var bool */
	public $showPrev;

	/** @var bool */
	public $showNext;

	/** @var int */
	public $prev;

	/** @var int */
	public $next;

	/**
	 * construct Pagination object with all our info
	 *
	 * @param bool $showPrev whether to show previous page link
	 * @param bool $showNext whether to show next page link
	 * @param int $prev     previous page number
	 * @param int $next     next page number
	 */
	public function __construct($showPrev, $showNext, $prev, $next) {
		$this->showPrev = $showPrev;
		$this->showNext = $showNext;
		$this->prev = $prev;
		$this->next = $next;
	}
}
