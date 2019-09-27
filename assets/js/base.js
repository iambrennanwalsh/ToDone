/**
 * @name:          base.js
 * @description:   This script imports all of the globally required javascript files. Anything used across the entire site is imported here.
 */

// Vue.js
import Vue from "vue";
window.Vue = Vue;

// Axios
import axios from "axios";
window.axios = axios;

// Scripts (scripts.js)
import { animate } from "./scripts.js";
window.animate = animate;
