/**
* @name:          base.js
* @description:   This script imports all of the globally required javascript files. Anything used across the entire site is imported here.
*/


// Vue.js
import Vue from 'vue';
window.Vue = Vue;

// Axios
import axios from 'axios';
window.axios = axios;


if (document.querySelector('body.front') !== null || document.querySelector('body.auth') !== null) {
	
	document.querySelector('.burger').addEventListener('click', openNav);
	document.querySelector('.hero-body').addEventListener('click', closeNav);
	
	function openNav() {
		document.getElementById('frontNav').classList.toggle('opensesame');}
	
	function closeNav() {
		document.getElementById('frontNav').classList.remove('opensesame');}
	
}

if (document.querySelector('body.dash') !== null) {
	
	document.querySelector('.burger').addEventListener('click', openDash);

	function openDash() {
		document.getElementById('sidebar').classList.toggle('opensesame');}
	
	function closeDash() {
		document.getElementById('sidebar').classList.remove('opensesame');}
	
}

