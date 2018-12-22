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

	function openNav() {
		document.getElementById('frontNav').classList.toggle('opensesame');
	}
	
}
