<template>
  <transition name="fade">
    <div v-show="state" class="is-active modal">
      <div @click.prevent="close" class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head has-background-light">
          <p class="modal-card-title" v-text="title"></p>
          <button @click.prevent="close" class="delete"></button>
        </header>
        <section class="modal-card-body">
          <slot name="content"></slot>
        </section>
        <footer class="modal-card-foot has-background-light">
          <button
            v-show="confirmbutton"
            type="button"
            @click.prevent="validateIt"
            :class="{ 'is-loading': loader }"
            class="is-primary button"
            v-text="confirmtext"
          ></button>
          <button
            v-show="closebutton"
            type="button"
            @click.prevent="close"
            class=" button"
          >
            Close
          </button>
        </footer>
      </div>
    </div>
  </transition>
</template>
<script>
export default {
  data() {
    return {
      state: false,
      loader: false
    };
  },
  props: {
    autoshow: Boolean,
    title: String,
    confirmtext: String,
    confirmbutton: Boolean,
    closebutton: Boolean,
    validate: Boolean
  },
  methods: {
    validateIt() {
      if (this.validate === false) this.confirm();
      else this.$emit("validate");
    },
    confirm() {
      this.loader = true;
      this.$emit("confirm");
    },
    open() {
      this.state = true;
    },
    close() {
      this.state = false;
      this.loader = false;
      this.$emit("clear");
    }
  },
  mounted() {
    if (this.autoshow === true) {
      this.state = true;
    }
  }
};
</script>
