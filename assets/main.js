/**
 * main js file for pagination example
 * - contains search ajax functions
 */

const GET = 'GET';
const POST = 'POST';
const NAME_LIST = document.getElementById('namelist').innerHTML;

function clearSearch() {
	document.getElementById('search').value = '';
	document.getElementById('namelist').innerHTML = NAME_LIST;
}

function ajaxSearch(e, el) {
	let term = el.value,
	callback = (data) => {
		let names = JSON.parse(data),
			ul = document.getElementById('namelist'),
			list = '<small>Search results for ' + term + '</small>',
			item;

		if (typeof names !== 'object' || names.length === undefined) {
			ul.innerHTML = NAME_LIST;
			return;
		}

		if (names.length === 0) {
			ul.innerHTML = '<h6>no results</h6>' + NAME_LIST;
			return;
		}

		for (let i = 0; i < names.length; i++) {
			item = '<li>' + names[i] + '</li>';
			list += item;
		}

		ul.innerHTML = list;
	};

	ajaxHelper('api/search.php', GET, {'term':term}, callback);
}

function ajaxHelper(url, method, data, callback) {
	let xhr = new XMLHttpRequest();
	xhr.onload = function () {
		callback(this.responseText);
	}

	if (GET === method && typeof data === 'object') {
		url += '?';
		for (key in data) {
			url += key + '=' + data[key];
		}
	}

	xhr.open(method, url, true);
	xhr.send(data);
}
