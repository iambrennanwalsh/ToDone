<template>
<div>
	<form v-on:submit.prevent="validateForm" class="m-top-30 field has-addons">
		<p class="control">
			<a class="button is-static">
				<span class='fa fa-lock'></span>
			</a>
		</p>
		<p class="control is-expanded">
			<input v-model="pass" v-bind:class="{'is-primary': passStatus && attempted}" class="input" type="password" placeholder="Enter the password for your account.">
		</p>
		<p class="control">
			<button v-on:submit.prevent="validateForm" :class="{'is-loading': loader}" class="is-primary button" type="submit">
				Continue <span class='is-pulled-right fa fa-chevron-right m-right-0'></span>
			</button>
		</p>
	</form>
	<transition name='fade'>
			<modal v-on:confirm="confirmModal" v-on:closemodal="closeModal" v-show="showModal" closebutton v-bind:loadin="loader">
				<span slot="title">Confirm account deletion.</span>
				<div slot="content">
					Last oppurtunity. You can not recover any lost information if you proceed. We are sorry to see you go. Are you sure?
				</div>
				<span slot="confirm">Close Account</span>
				<span slot="close">Nevermind</span>
			</modal>
		</transition>
		<p v-show="showError" class="has-text-primary m-top-20">Oh no. That password was incorrect! Try again.</p>
</div>
</template>


<script>
	import Modal from './modal.vue';
	
	export default {
		
		components: {
			'modal': Modal
		},

		data: function() {
			return {
				pass: '',
				attempted: false, 
				loader: false,
				showModal: false,
				showError: false} },
		
		computed: {
			passStatus: function() {
				return this.pass.length < 5 || this.pass.length > 30 } },
		
		methods: {
			
			validateForm: function(event) {
				this.attempted = true;
				if (this.passStatus == true) {
					event.preventDefault();} 
				else {
					this.showError = false;
					this.loader = true;
					this.checkPass();} },
			
			checkPass: function() {
				axios.post('/api/deleteuser', {
					pass: this.pass,
					do: 'check'
				}).then(response => {
					if (response.data.status == true) {
						this.showModal = true;}
					else {
						this.showError = true;
						this.passStatus = '';}
					this.loader = false;
				});},
	
			closeModal: function() {
				this.showModal = false;
				this.pass = '';
				this.attempted = false;},
			
			confirmModal: function() {
				this.loader = true;
				axios.post('/api/deleteuser', {
					do: 'delete'
				}).then(response => {
						window.location = '/'
				});
			}
		}
	}
</script>
