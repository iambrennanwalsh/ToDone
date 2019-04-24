<script>
	import login from './auth/login.vue'
	import signup from './auth/signup.vue'
	import forgot from './auth/forgot.vue'
	import change from './auth/change.vue'

	export default {}
	
	new Vue({

		el: "#auth",

		components: {
			'login': login,
			'signup': signup,
			'forgot': forgot,
			'change': change
		}

	})

</script>
