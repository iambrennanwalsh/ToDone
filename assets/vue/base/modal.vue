<script>
	Vue.component('modal', {
  	props: {
  		title: String,
  		content: String,
  		state: Boolean,
  		button: String,
			buttonTwo: String},
		methods: {
			stateChange: function(event) {
				event.preventDefault();
				if (this.state === true) {this.state = false;}
				else {this.state = true;}},
		},
		template: `
<div><div v-bind:class="{'is-active': state}" class="modal">
  <div v-on:click='stateChange' class="modal-background"></div>
  <div class="modal-card">
		<form id='newList' method='post'>
    <header class="modal-card-head has-background-light">
      <p class="modal-card-title" v-text='title'></p>
      <button v-on:click='stateChange' class="delete" aria-label="close"></button>
    </header>
    <section class="modal-card-body" v-html='content'>
    </section>
    <footer class="modal-card-foot has-background-light">
      <button v-on:click='stateChange' v-text='button' class="is-primary button"></button>
			<button v-on:click='stateChange' v-text='buttonTwo' class="button"></button>
    </footer>
		</form>
  </div>
</div>
</div>
`
	});
</script>