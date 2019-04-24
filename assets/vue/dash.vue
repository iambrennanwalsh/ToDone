<script>
	import Lists from './dash/lists.vue';
	import List from './dash/list.vue';
	import Profile from './dash/profile.vue';
	import Delete from './dash/delete.vue';
	import Modal from './base/modal';

	export default {}

	new Vue({
		
		components: {
			'lists': Lists,
			'list': List,
			'profile': Profile,
			'delete': Delete,
			'modal': Modal
			},

		el: "#dash",
		
		methods: {
			triggerAddModal: function() {
				this.$refs.listref.triggerAddModal();},
			triggerEditModal: function() {
			 	this.$refs.list.triggerEditModal();}
		 },
		
});
</script>