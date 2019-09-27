<script>
import message from "./base/message.vue";
import login from "./auth/login.vue";
import signup from "./auth/signup.vue";
import forgot from "./auth/forgot.vue";
import reset from "./auth/reset.vue";

export default {};

new Vue({
  el: "#vue",

  components: {
    "message-component": message,
    "login-component": login,
    "signup-component": signup,
    "forgot-component": forgot,
    "reset-component": reset
  },
  data() {
    return {
      nav: false
    }
  },
  methods: {
    show() {
      document.querySelector(".mobilemenu").classList.toggle("show"); 
    }
  }
});
</script>
