<template>
  <modal
    ref="modal"
    title="Edit Board"
    confirmbutton
    closebutton
    confirmtext="Edit Board"
    validate
    v-on:confirm="confirm"
    v-on:validate="validate"
    v-on:clear="clear"
  >
    <div slot="content">
      Change the name and description of your board.
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
                v-model="description"
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
      attempted: false,
      title: "",
      description: "",
      id: "",
      index: ""
    };
  },
  computed: {
    titleStatus: function() {
      return this.title === "";
    }
  },

  mounted() {
    EventBus.$on("edit", this.open);
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
        .put("/api/boards/" + this.id, {
          name: this.title,
          description: this.description,
          modified: new Date()
        })
        .then(response => {
          this.$root.boards.splice(this.index, 1, response.data);
          EventBus.$emit("edited", response.data);
          this.$refs.modal.close();
        });
    },

    clear() {
      this.attempted = false;
      this.title = "";
      this.description = "";
      this.index = "";
    },

    open(board, index) {
      this.title = board.name;
      this.description = board.description;
      this.id = board.id;
      this.index = index;
      this.$refs.modal.open();
    }
  }
};
</script>
