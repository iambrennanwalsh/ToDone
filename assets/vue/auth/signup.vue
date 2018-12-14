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
			userStatus: function() {return this.user === "" || this.user.length < 5 || this.user.length > 30},
			emailStatus: function() {return this.email === "" || this.email.length > 30},
			passStatus: function() {return this.pass === "" || this.pass.length < 5 || this.pass.length > 30},
			rpassStatus: function() {return this.rpass === "" || this.rpass.length > 30},
			fnameStatus: function() {return this.fname === "" || this.fname.length > 30},
			lnameStatus: function() {return this.lname === "" || this.lname.length > 30},
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