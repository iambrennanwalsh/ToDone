<script>
	import Notice from './base/modal';
	import Sidebar from './dash/sidebar';
	import Boards from './dash/boards';
	import Profile from './dash/profile';
	import Delete from './dash/delete';
	
	export default {}

	new Vue({
		
		components: {
			'Notice': Notice,
			'sidebar': Sidebar,
			'boards': Boards,
			'profile': Profile,
			'delete': Delete
		},

		el: "#dash",
		
		data() {
			return {
				boards: '',
				user: ''
			}
		},
		
		mounted() {
			axios.get('/api/boards')
				.then(response => {
					this.boards = response.data;
				});
			axios.get('/api/users')
				.then(response => {
					this.user = response.data;
			});
		}
		
});
</script>