<script>
	Vue.component('change', {
		
  	data: function () {
			return {
				ppass: "",
				rrpass: "",
				wasattempted: false,
    	}
		},
		computed: {
			thePassStatus: function() {return this.ppass.length <= 5 || this.ppass.length > 30},
			therPassStatus: function() {return this.rrpass.length <= 5 || this.rrpass.length > 30 || this.rrpass !== this.ppass},
		},
		methods: {
			validateTheForm: function(event) {	
				this.wasattempted = true;
				if (this.thePassStatus || this.therPassStatus) event.preventDefault();},
		},
		template: `
<form method="post" novalidate>
		<div class="field is-horizontal">
			<div class='field-body'>
				<div class='field'>
					<div class="control has-icons-left">
						<input v-model="ppass" v-bind:class="{'is-primary': wasattempted && thePassStatus}" type="password" class='input' name='pass' placeholder="Your new password." required>
						<span class="icon is-small is-left">
      				<i class="fa fa-key"></i>
    				</span>
					</div>
				</div>
				<div class='field'>
					<div class="control has-icons-left">
						<input v-model="rrpass" v-on:blur="validateTheForm" v-bind:class="{'is-primary': wasattempted && therPassStatus}" type="password" class='input' name='rpass' placeholder="Confirm password." required>
						<span class="icon is-small is-left">
      				<i class="fa fa-key"></i>
    				</span>
					</div>
				</div>
			</div>
		</div>
	<button v-on:click="validateTheForm" class="button is-primary is-pulled-right" type="submit">Reset Password!</button>
	<slot name="token"></slot>
</form>`
	});
</script>