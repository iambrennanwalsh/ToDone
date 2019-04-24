<template>
	<form method="post">
		<div class='field has-addons'>
			<div class="control">
				<span class="button is-static">
					<span class='fa fa-envelope'></span>
				</span>
			</div>
			<div class='control is-expanded'>
				<input type="text" placeholder="Phone # or Email Address" v-model="user" v-bind:class="{'is-primary': attempted && userStatus}" class="input" name="user">
			</div>
		</div>
		<div v-show="response" class="show formsent notification is-primary is-pulled-left m-left-0" v-text="response"></div>
		<button type="submit" v-on:click="validateForm" class="button is-primary is-pulled-right">Submit</button>
	</form>
</template>

<script>
	export default {

		data: function() {
			return {
				user: "",
				attempted: false
			}
		},
		props: {
			response: String
		},
		computed: {
			userStatus: function() {
				return this.user === ""
			}
		},
		methods: {
			validateForm: function(event) {
				this.attempted = true;
				if (this.userStatus) event.preventDefault();
			}
		}
	}
</script>
