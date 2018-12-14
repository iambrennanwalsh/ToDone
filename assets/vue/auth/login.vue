<script>
	Vue.component('login', {
		
  	data: function () {
			return {
				user: "",
				pass: "",
				attempted: false,
    	}
		},
		computed: {
			userStatus: function() {return this.user === "" || this.user.length > 30},
			passStatus: function() {return this.pass === "" || this.pass.length > 30},
		},
		methods: {
			validateForm: function(event) {	
				this.attempted = true;
				if (this.userStatus || this.passStatus) event.preventDefault();}
		},
		template: `
<form method="post" novalidate>
	<div class="field is-horizontal">		
		<div class='field-label is-normal'>
			<label class="label has-text-light">Username</label>
		</div>
		<div class='field-body'>
				<div class='field'>
					<div class="control has-icons-left">
			<input v-model="user" v-bind:class="{'is-primary': attempted && userStatus}" type="text" name="username" class="input" placeholder="Username or Email" required>
						<span class="icon is-small is-left">
							<i class="fa fa-user"></i>
						</span>
					</div>
				</div>
		</div>
	</div>
		<div class="field is-horizontal">		
		<div class='field-label is-normal'>
			<label class="label has-text-light">Password</label>
		</div>
		<div class='field-body'>
				<div class='field'>
					<div class="control has-icons-left">
						<input v-model="pass" v-bind:class="{'is-primary': attempted && passStatus}" type="password" name="password" class="input" placeholder="Password" required>
						<span class="icon is-small is-left">
							<i class="fa fa-key"></i>
						</span>
					</div>
				</div>
		</div>
	</div>
	<button v-on:click="validateForm" class="button is-primary is-pulled-right" type="submit">Sign In!</button>
	<slot name="token"></slot>
</form>`
	});
</script>