	<script>
	import lists from './dash/lists.vue'
	import modal from './dash/modal.vue'

	export default {   
	}	

	new Vue({
		components: {      
			'lists': lists,
			'modal': modal
		},
		
		el: "#dash",

		data: {
			activeList: '',
			addModal: false,
			deleteModal: false,
			listsObj: '',
		},
		methods: {
			initModal: function(activeList = ' ') {
				if(activeList == ' ') {
					 this.addModal = true;}
				else {
					this.deleteModal = true;
					this.activeList = activeList;
				}
			},
			closeModal: function() {
				this.activeList = '';
				this.addModal = false;
				this.deleteModal = false;
			}
		}, 
		created: function() {
			axios.get('/getlists').then(response => this.listsObj = response.data);
			this.$on('init-modal', this.initModal);
			this.$on('close-modal', this.closeModal);
	}})

	</script>