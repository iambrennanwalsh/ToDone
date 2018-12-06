/**
 * @name:          scripts.front.js
 * @description:   Any custom scripts specific to the front portion of the site go here. This is imported via ../front.js.
 */

if (document.querySelector('body.home') !== null) {

	var slider = new Vue({
		el: "#slider",
		data: {
			heading: ['Another To Do List App.', 'What Is On Your To Do?', 'You Got Things To Do!'],
			paragraph: ['Because getting it done is fun.', 'Knockin out your to do, is the cool thing to do.', 'Todo? More like to.. done.'],
			current: 0,
			timer: null
		},
		mounted: function () {
			this.startRotation();
		},
		methods: {
			startRotation: function () {
				this.timer = setInterval(this.next, 3000);
			},
			next: function () {
				this.current += 1;
			}
		}
	});
}

if (document.querySelector('body.contact') !== null) {
	var form = new Vue({
		el: "#form",
		data: {
			fname: "",
			email: "",
			subject: "",
			message: "",
			button: true
		},
		computed: {
			missingName: function() {
				return this.fname === '';},
			missingEmail: function() {
				return this.email === '';},
			missingSubject: function() {
				return this.subject === '';},
			missingMessage: function() {
				return this.message === '';},
		},
		methods: {
			validateForm: function (event) {
  			if (this.missingName || this.missingEmail || this.missingSubject || this.missingMessage) {event.preventDefault(); this.button == true;}
				else {this.button == false;}
				},
			}
	});
}