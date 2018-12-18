<template>
	<div class="outermodal">
	<div class="is-active modal">
  <div v-on:click.prevent="$root.$emit('close-modal')" class="modal-background"></div>
  <div class="modal-card">
		<form id='newList' method='post'>
    <header class="modal-card-head has-background-light">
      <p class="modal-card-title"><slot name="title"></slot></p>
      <button v-on:click.prevent="$root.$emit('close-modal')" class="delete"></button>
    </header>
    <section class="modal-card-body">
			<slot name="content"></slot>
    </section>
    <footer class="modal-card-foot has-background-light">
      <button v-show='deleteIt' v-on:click.prevent="$root.$emit('delete-list', activeList)" class="is-primary button"><slot name="delete"></slot></button>
			<button v-show='addIt' v-on:click.prevent="$root.$emit('add-list', activeList)" class="is-primary button"><slot name="add"></slot></button>
			<button v-show='cancelIt' v-on:click.prevent="$root.$emit('close-modal')" class="button"><slot name="cancel"></slot></button>
    </footer>
		</form>
  </div>
</div>
</div>
</template>


<script>
	export default {
		props: {
			deleteIt: Boolean,
			addIt: Boolean,
			cancelIt: Boolean,
			activeList: '',
		}
	}
</script>