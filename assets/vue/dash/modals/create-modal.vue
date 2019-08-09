<template>
  <modal
    ref="modal"
    title="Create a new board."
    closebutton
    confirmbutton
    confirmtext="Create Board"
    validate
    v-on:confirm="confirm"
    v-on:validate="validate"
    v-on:clear="clear"
  >
    <div slot="content">
      Choose a name for your new board and then write a description of it.
      <div class="m-top-20 field is-horizontal">
        <div class="field-label is-normal">
          <label class="label has-text-dark">Board Title</label>
        </div>
        <div class="field-body">
          <div class="field">
            <div class="control">
              <input
                v-model="title"
                :class="{ 'is-primary': attempted && titleStatus }"
                class="input"
                type="text"
                name="title"
                placeholder="e.g. Meeting Times.."
              />
            </div>
          </div>
        </div>
      </div>
      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label has-text-dark">Board Description</label>
        </div>
        <div class="field-body">
          <div class="field">
            <div class="control">
              <textarea
                v-model="desc"
                class="textarea"
                name="message"
                placeholder="What's this board all about?"
              ></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>
<script>
import modal from "./../../base/modal.vue";
import { EventBus } from "./../../eventbus.vue";
export default {
  components: {
    modal: modal
  },
  data() {
    return {
      title: "",
      desc: "",
      attempted: false
    };
  },
  computed: {
    titleStatus: function() {
      return this.title === "";
    }
  },
  methods: {
    validate() {
      this.attempted = true;
      if (this.titleStatus !== true) {
        this.$refs.modal.confirm();
      }
    },
    confirm() {
      axios
        .post("/api/boards", {
          name: this.title,
          description: this.desc,
          created: new Date(),
          modified: new Date(),
          total: 0,
          completed: 0,
          userid: "/api/users/" + this.$root.user.id
        })
        .then(response => {
          this.$root.boards.push(response.data);
          this.$refs.modal.close();
        });
    },
    clear() {
      this.attempted = false;
      this.title = "";
      this.desc = "";
    },
    open() {
      this.$refs.modal.open();
    }
  },
  mounted() {
    EventBus.$on("create", this.open);
  }
};
</script>
