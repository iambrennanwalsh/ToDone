<template>
	<div>
		<form v-on:submit.prevent="validate" class="m-top-30 field has-addons">
			<p class="control">
				<a class="button is-static">
					<span class='fa fa-lock'></span>
				</a>
			</p>
			<p class="control is-expanded">
				<input v-model="pass" v-bind:class="{'is-primary': passStatus && attempted || incorrect }" class="input" type="password" placeholder="Enter the password for your account.">
			</p>
			<p class="control">
				<button v-on:submit.prevent="validate" :class="{'is-loading': loader}" class="is-primary button" type="submit">
					Continue <span class='is-pulled-right fa fa-chevron-right m-right-0'></span>
				</button>
			</p>
		</form>
		<modal ref="delete" title="Confirm account deletion." confirmbutton closebutton confirmtext="Close Account">
			<span slot="content">
				Last oppurtunity. You can not recover any lost information if you proceed. We are sorry to see you go. Are you sure?
			</span>
		</modal>
		<modal ref="info" title="Check your email." closebutton>
			<span slot="content">
				We sent you an email containing an account deletion confirmation link. See the email for more info.
			</span>
		</modal>
	</div>
</template>


<script>
	import Modal from './modal';

	export default {

		components: {
			'modal': Modal
		},

		data: function() {
			return {
				pass: '',
				attempted: false,
				loader: false,
				incorrect: false
			}
		},

		computed: {
			passStatus() {
				return this.pass.length < 5 || this.pass.length > 30
			}
		},

		methods: {

			validate() {
				this.attempted = true;
				if (this.passStatus == true) return false;
				else {
					this.loader = true;
					this.checkPass();
				}
			},

			checkPass() {
				axios.post('/api/users/' + this.$root.user[0].id + '/check', {
					password: this.pass
				}).then(response => {
					if (response.data.status) this.$refs.delete.open();
					else {
						this.loader = false;
						this.incorrect = true;}
				});
			},

			confirm() {
				this.loader = true;
				this.$refs.delete.close();
				axios.post('/dashboard/profile', {context: "close"})
					.then(response => {
						this.$refs.info.open();
				});
			},
			
			clear() {
				this.pass = "";
				this.loader = "";
				this.attempted = "";
			}
		}
	}

</script>
