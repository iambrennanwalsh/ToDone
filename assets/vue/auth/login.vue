<script>
export default {
  data: function() {
    return {
      user: "",
      pass: "",
      attempted: false
    };
  },
  computed: {
    userStatus: function() {
      return this.user === "" || this.user.length > 30;
    },
    passStatus: function() {
      return this.pass === "" || this.pass.length > 30;
    }
  },
  methods: {
    validateForm: function(event) {
      this.attempted = true;
      if (this.userStatus || this.passStatus) event.preventDefault();
    }
  }
};
</script>
