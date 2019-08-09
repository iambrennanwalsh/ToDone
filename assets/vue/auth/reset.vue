<script>
export default {
  data: function() {
    return {
      pass: "",
      rpass: "",
      attempted: false
    };
  },
  computed: {
    passStatus: function() {
      return this.pass.length <= 5 || this.pass.length > 30;
    },
    rpassStatus: function() {
      return (
        this.rpass.length <= 5 ||
        this.rpass.length > 30 ||
        this.rpass !== this.pass
      );
    }
  },
  methods: {
    validate: function(event) {
      this.attempted = true;
      if (this.passStatus || this.rpassStatus) event.preventDefault();
    }
  }
};
</script>
