<template>
  <article
    v-show="state"
    class="message animated"
    :class="[{ fadeInUp: out, fadeOutDown: !out }, type]"
  >
    <div class="message-body" v-html="message"></div>
  </article>
</template>

<script>
import { EventBus } from "./../eventbus.vue";
export default {
  data() {
    return {
      state: false,
      message: "",
      type: "",
      out: false
    };
  },
  props: {
    classtype: String,
    value: String
  },
  methods: {
    open(type, message) {
      this.type = type;
      this.message = message;
      this.out = true;
      this.state = true;
      setTimeout(() => {
        this.out = false;
        setTimeout(() => {
          this.state = false;
        }, 2000);
      }, 5000);
      this.state;
    }
  },
  mounted() {
    if (this.classtype && this.value) {
      this.open(this.classtype, this.value);
    }
    EventBus.$on("openMessage", this.open);
  }
};
</script>
