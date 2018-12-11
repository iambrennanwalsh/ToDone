<script>
	Vue.component('slider', {
  data: function () {
    return {
			heading: ['Another To Do List App.', 'What Is On Your To Do?', 'You Got Things To Do!'],
			paragraph: ['Because getting it done is fun.', 'Knockin out your to do, is the cool thing to do.', 'Todo? More like to.. done.'],
			current: 0,
			timer: null
    }
  },
  template: `<div><h1 v-text='heading[current % heading.length]' class='title has-text-grey-dark'></h1><p v-text='paragraph[current % paragraph.length]' class='subtitle'></p><button class='button is-primary has-text-weight-bold' type='button'>We know you\'ll <span class='fa fa-heart'></span> our demo</button></div>`,
	mounted: function () {
			this.startRotation();},
	methods: {
			startRotation: function () {
				this.timer = setInterval(this.next, 3000);},
			next: function () {
				this.current += 1;}}
});
</script>