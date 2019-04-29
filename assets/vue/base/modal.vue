<template>
	<transition name="fade">
		<div class="is-active modal" v-show="stateVal">
			<div @click.prevent='stateChange' class="modal-background"></div>
			<div class="modal-card">
				<form id='newList' method='post'>
					<header class="modal-card-head has-background-light">
						<p class="modal-card-title" v-text='title'></p>
						<button @click.prevent='stateChange' class="delete"></button>
					</header>
					<section class="modal-card-body" v-html='content'>
					</section>
					<footer class="modal-card-foot has-background-light">
						<button @click.prevent='stateChange' v-text='button' class="is-primary button"></button>
					</footer>
				</form>
			</div>
		</div>
	</transition>
</template>

<script>
	export default {
		data() {
			return {
				stateVal: this.state
			}
		},
		props: {
			title: String,
			content: String,
			state: Boolean,
			button: String,
		},
		methods: {
			stateChange: function(event) {
				this.state === true ? this.stateVal = false : this.stateVal = true;
			},
		},
	}

</script>

<style scoped>
	
   .fade-enter-active {
        transition: opacity .25s;
    }
    .fade-leave-active {
        opacity: 0;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
	
</style>