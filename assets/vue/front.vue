<script>
import message from "./base/message.vue";
import slider from "./front/slider";
import contact from "./front/contact";

export default {};

new Vue({
  components: {
    "slider-component": slider,
    "message-component": message,
    "contact-component": contact
  },

  el: "#vue",
  
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
