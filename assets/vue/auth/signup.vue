<script>
export default {
  data: function() {
    return {
      phone: "",
      email: "",
      pass: "",
      rpass: "",
      fname: "",
      lname: "",
      attemptedSubmit: false,
      attemptedRpass: false,
      countryList: "",
      accept: "",
      change: false
    };
  },
  props: {
    oauth: Boolean,
    oauthemail: String,
    oauthfname: String,
    oauthlname: String
  },
  computed: {
    phoneStatus: function() {
      return this.phone === "" || this.phone.length > 30;
    },
    emailStatus: function() {
      return (
        this.email === "" || this.email.length > 30 || !this.email.includes("@")
      );
    },
    passStatus: function() {
      return this.pass === "" || this.pass.length < 5 || this.pass.length > 30;
    },
    rpassStatus: function() {
      return (
        this.rpass === "" || this.pass.length < 5 || this.rpass.length > 30
      );
    },
    acceptStatus: function() {
      return this.accept === "";
    },
    fnameStatus: function() {
      return this.fname === "" || this.fname.length > 30;
    },
    lnameStatus: function() {
      return this.lname === "" || this.lname.length > 30;
    },
    identical: function() {
      return this.pass !== this.rpass;
    }
  },
  methods: {
    validateForm: function(event) {
      this.attemptedSubmit = true;
      if (
        this.phoneStatus ||
        this.passStatus ||
        this.acceptStatus ||
        this.emailStatus ||
        this.rpassStatus ||
        this.fnameStatus ||
        this.lnameStatus ||
        this.identical
      )
        event.preventDefault();
    },
    validatePasswords: function() {
      this.attemptedRpass = true;
    }
  },
  mounted() {
    if (this.oauth == true) {
      this.email = this.oauthemail;
      this.fname = this.oauthfname;
      this.lname = this.oauthlname;
    }
  }
};
</script>
