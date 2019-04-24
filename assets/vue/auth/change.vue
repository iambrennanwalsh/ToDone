<template>
	<form method="post" @submit="validateTheForm">
		<div class="field is-horizontal">
			<div class='field-body'>
				<div class='field'>
					<div class="control has-icons-left">
						<input type="password" v-model="ppass" v-bind:class="{'is-primary': wasattempted && thePassStatus}" class="input" placeholder="New Password" name="password">
						<span class="icon is-small is-left">
							<i class="fa fa-key"></i>
						</span>
					</div>
				</div>
				<div class='field'>
					<div class="control has-icons-left">
						<input type="password" v-model="rrpass" v-on:blur="validateTheForm" v-bind:class="{'is-primary': wasattempted && therPassStatus}" class="input" placeholder="Confirm Password" name="confirm">
						<span class="icon is-small is-left">
							<i class="fa fa-key"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
		<button type="submit" v-on:click="validateTheForm" class="button is-primary">Submit</button>
		<input type="hidden" :value="id" name="id">
	</form>
</template>

<script>
	export default {

		data: function() {
			return {
				ppass: "",
				rrpass: "",
				wasattempted: false,
			}
		},
		props: {
			id: Number
		},
		computed: {
			thePassStatus: function() {
				return this.ppass.length <= 5 || this.ppass.length > 30
			},
			therPassStatus: function() {
				return this.rrpass.length <= 5 || this.rrpass.length > 30 || this.rrpass !== this.ppass
			},
		},
		methods: {
			validateTheForm: function(event) {
				this.wasattempted = true;
				if (this.thePassStatus || this.therPassStatus) event.preventDefault();
			},
		},

	}

</script>
