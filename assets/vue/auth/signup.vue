<script>
	Vue.component('signup', {
		
  	data: function () {
			return {
				user: "",
				email: "",
				pass: "",
				rpass: "",
				fname: "",
				lname: "",
				attemptedSubmit: false,
				attemptedRpass: false
    	}
		},
		computed: {
			userStatus: function() {return this.user === ""},
			emailStatus: function() {return this.email === ""},
			passStatus: function() {return this.pass === ""},
			rpassStatus: function() {return this.rpass === ""},
			fnameStatus: function() {return this.fname === ""},
			lnameStatus: function() {return this.lname === ""},
			identical: function() {return this.pass !== this.rpass}
		},
		methods: {
			validateForm: function(event) {	
				this.attemptedSubmit = true;
				if (this.userStatus || this.passStatus || this.emailStatus || this.rpassStatus || this.fnameStatus || this.lnameStatus || this.identical) event.preventDefault();},
			validatePasswords: function() {
				this.attemptedRpass = true;
			}
		}
	});
</script>