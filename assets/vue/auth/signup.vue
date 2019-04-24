<template>
	<form id="signup" method="post" v-on:submit="validateForm">
		<div class="field is-horizontal" title="No parenhesis nor dashes please. Numbers only. Ex: 3333333333">
			<div class='field-label is-normal'>
				<label class="label has-text-light">Phone #<sup>*</sup></label>
			</div>
			<div class='field-body'>
				<div class='field has-addons'>
					<div class="control">
						<span class="button is-static">
							<span class='fa fa-phone'></span>
						</span>
					</div>
					<div class='control is-expanded'>
						<input name="user[phone]" type="tel" v-model="phone" v-bind:class="{'is-primary': attemptedSubmit && phoneStatus}" placeholder='Phone #' class='input'>
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal" title="Ex: xxxxx@xxxxx.xxx">
			<div class='field-label is-normal'>
				<label class="label has-text-light">Email<sup>*</sup></label>
			</div>
			<div class='field-body'>
				<div class='field has-addons'>
					<div class="control">
						<span class="button is-static">
							<span class='fa fa-envelope'></span>
						</span>
					</div>
					<div class='control is-expanded'>
						<input name="user[email]" type="text" v-model="email" v-bind:class="{'is-primary': attemptedSubmit && emailStatus}" placeholder='Email Address' class='input'>
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal" title="Passwords must be between 5 and 30 characters.">
			<div class='field-label is-normal has-text-light'>
				<label class="label has-text-light">Password<sup>*</sup></label>
			</div>
			<div class='field-body'>
				<div class='field has-addons'>
					<div class="control">
						<span class="button is-static">
							<span class='fa fa-key'></span>
						</span>
					</div>
					<div class='control is-expanded'>
						<input name="user[password]" type="password" v-model="pass" v-bind:class="{'is-primary': attemptedSubmit && passStatus}" placeholder='Password' class='input'>
					</div>
				</div>
				<div class='field has-addons'>
					<div class="control">
						<span class="button is-static">
							<span class='fa fa-key'></span>
						</span>
					</div>
					<div class='control is-expanded'>
						<input name="user[rpass]" type="password" v-model="rpass" @blur="validatePasswords" v-bind:class="{'is-primary': identical && attemptedRpass || attemptedSubmit && rpassStatus}" placeholder='Repeat Password' class='input'>
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal" title="No more than 30 characters please.">
			<div class='field-label is-normal has-text-light'>
				<label class="label has-text-light">Your name<sup>*</sup></label>
			</div>
			<div class='field-body'>
				<div class='field has-addons'>
					<div class="control">
						<span class="button is-static">
							<span class='fa fa-user'></span>
						</span>
					</div>
					<div class='control is-expanded'>
						<input name="user[fname]" type="text" v-model="fname" v-bind:class="{'is-primary': attemptedSubmit && fnameStatus}" placeholder='First Name' class='input'>
					</div>
				</div>
				<div class='field has-addons'>
					<div class="control">
						<span class="button is-static">
							<span class='fa fa-user'></span>
						</span>
					</div>
					<div class='control is-expanded'>
						<input name="user[lname]" type="text" v-model="lname" v-bind:class="{'is-primary': attemptedSubmit && lnameStatus}" placeholder='Last Name' class='input'>
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal">
			<div class='field-label is-normal has-text-light'>
				<label class="label has-text-light">Country<sup>*</sup></label>
			</div>
			<div class='field-body'>
				<div class='field'>
					<div class="control has-icons-left">
						<div class="select is-rounded">
							<select name="user[country]" class="select">
								<option v-for="country in countryList" v-text="country.name" :value="country.name"></option>
							</select>
							<span class="icon is-small is-left">
								<i class="fa fa-globe"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal">
			<div class='field-label is-normal has-text-light'>
				<label class="label has-text-light">Gender<sup>*</sup></label>
			</div>
			<div class='field-body'>
				<div class='field'>
					<div class="control has-icons-left">
						<div class="select is-rounded">
							<select class="select" name="user[gender]">
								<option value="male">Male</option>
								<option value="female">Female</option>
								<option value="robot">Robot</option>
								<option value="na">Rather not say.</option>
							</select>
							<span class="icon is-small is-left">
								<i class="fa fa-venus"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<label><input type="checkbox" v-bind:class="{'is-primary': attemptedSubmit && acceptStatus}" class="m-right-10 checkbox" value="true" v-model="accept">I accept the <a class="has-text-info" href="/terms">Terms and Conditions</a>.</label>
		<div class="field is-pulled-right">
			<div class="control">
				<button v-on:click="validateForm" class='button is-primary'>Sign Up</button>
			</div>
		</div>
		<div class="show formsent is-pulled-left">
		</div>
	</form>
</template>
<script>
	export default {

		data: function() {
			return {
				phone: "",
				email: "",
				pass: "",
				rpass: "",
				fname: "",
				lname: "",
				attemptedSubmit: false,
				attemptedRpass: false,
				countryList: "",
				accept: "",
			}
		},
		computed: {
			phoneStatus: function() {
				return this.phone === "" || this.phone.length > 30
			},
			emailStatus: function() {
				return this.email === "" || this.email.length > 30 || !this.email.includes("@")
			},
			passStatus: function() {
				return this.pass === "" || this.pass.length < 5 || this.pass.length > 30
			},
			rpassStatus: function() {
				return this.rpass === "" || this.pass.length < 5 || this.rpass.length > 30
			},
			acceptStatus: function() {
				return this.accept === ""
			},
			fnameStatus: function() {
				return this.fname === "" || this.fname.length > 30
			},
			lnameStatus: function() {
				return this.lname === "" || this.lname.length > 30
			},
			identical: function() {
				return this.pass !== this.rpass
			}
		},
		methods: {
			validateForm: function(event) {
				this.attemptedSubmit = true;
				if (this.phoneStatus || this.passStatus || this.acceptStatus || this.emailStatus || this.rpassStatus || this.fnameStatus || this.lnameStatus || this.identical) event.preventDefault();
			},
			validatePasswords: function() {
				this.attemptedRpass = true;
			}
		},
		mounted() {
			axios.get("https://restcountries.eu/rest/v1/all")
				.then(response => {
					this.countryList = response.data;
				});
		}
	}

</script>
