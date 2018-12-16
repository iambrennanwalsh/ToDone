<script>
	Vue.component('change', {
		
  	data: function () {
			return {
				ppass: "",
				rrpass: "",
				wasattempted: false,
    	}
		},
		computed: {
			thePassStatus: function() {return this.ppass.length <= 5 || this.ppass.length > 30},
			therPassStatus: function() {return this.rrpass.length <= 5 || this.rrpass.length > 30 || this.rrpass !== this.ppass},
		},
		methods: {
			validateTheForm: function(event) {	
				this.wasattempted = true;
				if (this.thePassStatus || this.therPassStatus) event.preventDefault();},
		},

	});
</script>