<script>
import { EventBus } from "./../eventbus.vue";

export default {
  data() {
    return {
      fname: "",
      email: "",
      subject: "",
      message: "",
      attempted: false,
      load: false,
      response: ""
    };
  },
  computed: {
    nameStatus: function() {
      return this.fname === "";
    },
    emailStatus: function() {
      return this.email === "";
    },
    subjectStatus: function() {
      return this.subject === "";
    },
    messageStatus: function() {
      return this.message === "";
    },
    status() {
      return (
        this.nameStatus ||
        this.emailStatus ||
        this.subjectStatus ||
        this.messageStatus
      );
    }
  },
  methods: {
    validateForm(event) {
      this.attempted = true;
      this.load = true;
      if (this.status) {
        this.load = false;
      } else {
        this.send(event);
      }
    },
    send(event) {
      var form = document.getElementById("contactform");
      var data = new FormData(form);
      var xhr = new XMLHttpRequest();
      xhr.addEventListener("load", e => {
        this.attempted = false;
        this.fname = "";
        this.email = "";
        this.subject = "";
        this.message = "";
        this.load = false;
        this.response = JSON.parse(xhr.responseText);
        let flash = this.response["status"] ? "is-success" : "is-danger";
        let message = this.response["message"];
        EventBus.$emit("openMessage", flash, message);
      });
      xhr.open("POST", "/contact");
      xhr.send(data);
    }
  }
};
</script>
