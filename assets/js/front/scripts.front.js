/**
* @name:          scripts.front.js
* @description:   Any custom scripts specific to the front portion of the site go here. This is imported via ../front.js.
*/


var slider = new Vue({
	el: "#slider",
	data: {
		heading: ['Another To Do List App.', 'What Is On Your To Do?', 'You Got Things To Do!'],
		paragraph: ['Because getting it done is fun', 'Knockin out your to do, is the cool thing to do.', 'Todo? More like to.. done.'],
		current: 0,
		timer: null
	},
	mounted: function() {
		this.startRotation();
	},
	methods: {
		startRotation: function() {
			this.timer = setInterval(this.next, 3000);
		},
		next: function() {
			this.current += 1;
		},
		stopRotation() {
			clearTimeout(this.timer);
			this.timer = null;
		}
	}
});