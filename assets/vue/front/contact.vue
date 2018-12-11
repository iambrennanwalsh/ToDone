<script>
	Vue.component('contact', {
		
  	data: function () {
			return {
				fname: "",
				email: "",
				subject: "",
				message: "",
				button: true,
				show: ""
    	}
		},
		methods: {
			validateForm: function(event) {	
  			if (event.target.value === '') {
					event.target.classList.add('is-primary');
				} else {
					event.target.classList.remove('is-primary');}
				if (this.fname === "" || this.email === "" || this.subject === "" || this.message === "") {
					this.button = true; 
				} else {
					this.button = false;}
			},
			sendit: function(event) {
				var form = document.getElementById('contactform');
				var data = new FormData(form);
				var xhr = new XMLHttpRequest();
				xhr.addEventListener("load", event => {
					this.show = "show";
					this.fname = "";
					this.email = "";
					this.subject = "";
					this.message = "";
					this.buttton = true;
				});
				xhr.open("POST", "https://bizplan.local/contactform");
				xhr.send(data);}
		},	
		template: `
  <form id='contactform' method="post" v-on:submit.prevent="sendit">
		<div class="field is-horizontal">
			<div class='field-label is-normal'>
  			<label class="label has-text-light">From<sup>*</sup></label>
			</div>
			<div class='field-body'>
				<div class='field'>
					<div class="control has-icons-left">
						<input v-model='fname' v-on:blur='validateForm' name='fname' type='text' placeholder='Full Name' class='input'>
						<span class="icon is-small is-left">
							<i class="fa fa-user"></i>
						</span>
					</div>
				</div>
				<div class="field">
					<div class="control has-icons-left">
						<input v-model='email' v-on:blur='validateForm' name='email' type='email' placeholder='Email' class='input'>
						<span class="icon is-small is-left">
							<i class="fa fa-envelope"></i>
    				</span>
					</div>
				</div>
			</div>
		</div>			
		<div class="field is-horizontal">
			<div class='field-label is-normal'>
  			<label class="label has-text-light">Subject<sup>*</sup></label>
			</div>
			<div class='field-body'>
				<div class='field'>
  				<div class="control has-icons-left">
						<input v-model='subject' v-on:blur='validateForm' name='subject' type='text' placeholder='Subject' class='input'>
    				<span class="icon is-small is-left">
      				<i class="fa fa-chevron-right"></i>
    				</span>
  				</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal">
			<div class='field-label is-normal has-text-light'>
  			<label class="label has-text-light">Message<sup>*</sup></label>
			</div>
			<div class="field-body">
				<div class="field">
					<div class="control">
						<textarea v-model='message' v-on:blur='validateForm' name="message" placeholder="Message.." class="textarea"></textarea>
  				</div>
				</div>
			</div>
		</div>
		<div class="field is-pulled-right">
  		<div class="control">
				<button v-bind:disabled='button' v-on:submit.prevent="sendit" type="submit" class="button is-primary">Send Message</button>
  		</div>
		</div>
		<div v-bind:class='show' class='formsent notification is-success is-pulled-right'>Your message has been sent.</div>
	</form>`	
	});
</script>