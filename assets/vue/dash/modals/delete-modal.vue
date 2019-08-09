<template>
  <modal
    ref="modal"
    title="Delete Board"
    confirmbutton
    closebutton
    confirmtext="Delete Board"
    v-on:confirm="confirm"
  >
    <span slot="content">
      Are you absolutely sure you'd like to delete this board? It cannot be
      recovered!
    </span>
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
      board: "",
      index: ""
    };
  },
  methods: {
    confirm() {
      axios.delete("/api/boards/" + this.board.id).then(response => {
        this.$delete(this.$root.boards, this.index);
        this.$refs.modal.close();
      });
    },
    open(board, index) {
      this.board = board;
      this.index = index;
      this.$refs.modal.open();
    }
  },
  mounted() {
    EventBus.$on("delete", this.open);
  }
};
</script>
