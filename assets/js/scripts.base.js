/**
* @name:          scripts.base.js
* @description:   This script is for any custom javascript that is required globally. It is imported from base.js.
*/

document.querySelector('.burger').addEventListener('click', openNav);

function openNav() {
	document.getElementById('frontNav').classList.toggle('opensesame');
}