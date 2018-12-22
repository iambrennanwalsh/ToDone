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
					<button type="button" v-show='deleteIt' v-on:click.prevent="delmodal" class="is-primary button">
						<slot name="delete"></slot>
					</button>
					<button type="button" v-show='addIt' v-on:click.prevent="addmodal" :class="{'is-loading': loadin}" class="is-primary button">
						<slot name="add"></slot>
					</button>
					<button v-show='closeIt' v-on:click.prevent="closemodal" class="button">
						<slot name="close"></slot>
					</button>
				</footer>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			deleteIt: Boolean,
			addIt: Boolean,
			closeIt: Boolean,
			loadin: Boolean},

		methods: {
			closemodal: function() {
				this.$emit('close-modal');},
			delmodal: function() {
				this.$emit('del-modal');},
			addmodal: function() {
				this.$emit('add-modal');}}
	}

</script>
