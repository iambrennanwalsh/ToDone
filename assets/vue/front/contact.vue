<script>
	Vue.component('contact', {
  	data: function () {
			return {
				fname: "",
				email: "",
				subject: "",
				message: "",
				attempted: false,
				show: false
    	}
		},
		computed: {
			nameStatus: function() {return this.fname === ""},
			emailStatus: function() {return this.email === ""},
			subjectStatus: function() {return this.subject === ""},
			messageStatus: function() {return this.message === ""}
		},
		methods: {
			validateForm: function(event) {	
				this.attempted = true;
				if (this.nameStatus || this.emailStatus || this.subjectStatus || this.messageStatus) {}
				else {this.sendit(event)}
			},	
			sendit: function(event) {
				var form = document.getElementById('contactform');
				var data = new FormData(form);
				var xhr = new XMLHttpRequest();
				xhr.addEventListener("load", event => {
					this.show = true;
					this.attempted = false;
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
  <form id='contactform' method="post" novalidate v-on:submit.prevent="validateForm">
		<div class="field is-horizontal">
			<div class='field-label is-normal'>
  			<label class="label has-text-light">From<sup>*</sup></label>
			</div>
			<div class='field-body'>
				<div class='field'>
					<div class="control has-icons-left">
						<input v-model='fname' v-bind:class="{'is-primary': attempted && nameStatus}" name='fname' type='text' placeholder='Full Name' class='input'>
						<span class="icon is-small is-left">
							<i class="fa fa-user"></i>
						</span>
					</div>
				</div>
				<div class="field">
					<div class="control has-icons-left">
						<input v-model='email' v-bind:class="{'is-primary': attempted && emailStatus}" name='email' type='email' placeholder='Email' class='input'>
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
						<input v-model='subject' v-bind:class="{'is-primary': attempted && subjectStatus}" name='subject' type='text' placeholder='Subject' class='input'>
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
						<textarea v-model='message' v-bind:class="{'is-primary': attempted && messageStatus}" name="message" placeholder="Message.." class="textarea"></textarea>
  				</div>
				</div>
			</div>
		</div>
		<div class="field is-pulled-right">
  		<div class="control">
				<button v-on:submit.prevent="validateForm" type="submit" class="button is-primary">Send Message</button>
  		</div>
		</div>
		<div v-bind:class='{show: show}' class='formsent notification is-success is-pulled-left'>Your message has been sent.</div>
	</form>`	
	});
</script>