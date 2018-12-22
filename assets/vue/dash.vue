<script>
	import Lists from './dash/lists.vue';
	import List from './dash/list.vue';

	export default {}

	new Vue({
		
		components: {
			'lists': Lists,
			'list': List},

		el: "#dash",
		
		methods: {
			triggerAddModal: function() {
				this.$refs.listref.triggerAddModal();}
			},
		
});
</script>