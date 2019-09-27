<script>
import CreateModal from "./dash/modals/create-modal";
import DeleteModal from "./dash/modals/delete-modal";
import EditModal from "./dash/modals/edit-modal";
import Message from "./base/message";
import Boards from "./dash/boards";
import Board from "./dash/board";
import Profile from "./dash/profile";
import Delete from "./dash/delete";
import { EventBus } from "./eventbus.vue";

export default {};

new Vue({
  components: {
    "message-component": Message,
    "create-modal": CreateModal,
    "delete-modal": DeleteModal,
    "edit-modal": EditModal,
    boards: Boards,
    board: Board,
    "profile-component": Profile,
    "delete-component": Delete
  },

  el: "#vue",

  data() {
    return {
      boards: "",
      user: "",
      nav: false
    };
  },

  mounted() {
    axios.get("/api/boards").then(response => {
      this.boards = response.data;
      EventBus.$emit("boards", this.boards);
    });
    axios.get("/api/users").then(response => {
      this.user = response.data[0];
    });
  }
});
</script>
