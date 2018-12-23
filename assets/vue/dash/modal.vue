<template>
	<div class="is-active modal">
		<div v-on:click.prevent="closemodal" class="modal-background"></div>
		<div class="modal-card">
				<header class="modal-card-head has-background-light">
					<p class="modal-card-title">
						<slot name="title"></slot>
					</p>
					<button v-on:click.prevent="closemodal" class="delete"></button>
				</header>
				<section class="modal-card-body">
					<slot name="content"></slot>
				</section>
				<footer class="modal-card-foot has-background-light">
					<button type="button" v-on:click.prevent="confirm" :class="{'is-loading': loadin}" class="is-primary button">
						<slot name="confirm"></slot>
					</button>
					<button v-show='closebutton' type="button" v-on:click.prevent="closemodal" class=" button">
						<slot name="close"></slot>
					</button>
				</footer>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			closebutton: Boolean,
			loadin: Boolean
		},

		methods: {
			closemodal: function() {
				this.$emit('closemodal');},
			confirm: function() {
				this.$emit('confirm');}
	}
	}

</script>