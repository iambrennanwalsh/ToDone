<template>
  <div>
    <form v-on:submit.prevent="validate" class="m-top-30 field has-addons">
      <p class="control">
        <a class="button is-static">
          <span class="fa fa-lock"></span>
        </a>
      </p>
      <p class="control is-expanded">
        <input
          v-model="pass"
          v-bind:class="{
            'is-primary': (passStatus && attempted) || incorrect
          }"
          class="input"
          type="password"
          placeholder="Enter the password for your account."
        />
      </p>
      <p class="control">
        <button
          v-on:submit.prevent="validate"
          :class="{ 'is-loading': loader }"
          class="is-primary button"
          type="submit"
        >
          Continue
          <span class="is-pulled-right fa fa-chevron-right m-right-0"></span>
        </button>
      </p>
    </form>
    <modal
      ref="delete"
      title="Are you sure?"
      confirmbutton
      closebutton
      confirmtext="Close Account"
      v-on:confirm="confirm"
      v-on:clear="clear"
    >
      <span slot="content">
        You can not recover any lost information if you proceed. We are sorry to
        see you go. Are you sure? If you are, click the confirm button below.
      </span>
    </modal>
  </div>
</template>

<script>
import Modal from "./../base/modal.vue";
export default {
  components: {
    modal: Modal
  },

  data: function() {
    return {
      pass: "",
      attempted: false,
      loader: false,
      incorrect: false
    };
  },

  computed: {
    passStatus() {
      return this.pass.length < 5 || this.pass.length > 30;
    }
  },

  methods: {
    validate() {
      this.attempted = true;
      if (this.passStatus) return false;
      else {
        this.loader = true;
        this.checkPassword();
      }
    },

    checkPassword() {
      axios
        .post("/api/users/" + this.$root.user.id + "/check", {
          password: this.pass
        })
        .then(response => {
          if (response.data.status) this.$refs.delete.open();
          else {
            this.loader = false;
            this.incorrect = true;
          }
        });
    },

    confirm() {
      this.loader = true;
      axios.delete("/api/users/" + this.$root.user.id).then(response => {
        window.location = "/";
      });
    },

    clear() {
      this.pass = "";
      this.loader = "";
      this.attempted = "";
    }
  }
};
</script>
