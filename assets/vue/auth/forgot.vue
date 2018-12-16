<script>
	Vue.component('forgot', {
		
  	data: function () {
			return {
				user: "",
				attempted: false
    	}
		},
		computed: {
			userStatus: function() {return this.user === ""}
		},
		methods: {
			validateForm: function(event) {	
				this.attempted = true;
				if (this.userStatus) event.preventDefault();}
		}
	});
</script>