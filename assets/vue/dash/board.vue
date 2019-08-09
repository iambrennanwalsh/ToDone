<template>
  <div id="board">
    <div class="columns">
      <div class="column is-12">
        <button
          @click="edit"
          class="button is-primary is-inverted is-pulled-right"
        >
          <span class="fa fa-paint-brush m-left-0"></span> Edit Board
        </button>
        <button
          @click="plus"
          :class="{ 'is-loading': loader }"
          class="button is-primary is-pulled-right m-right-10"
        >
          <span class="fa fa-plus m-left-0"></span> Add List
        </button>
        <h1
          v-text="board.name"
          id="listtitle"
          class="title has-text-grey-dark"
        ></h1>
        <p
          v-text="board.description"
          id="listsub"
          class="subtitle has-text-dark"
        ></p>
      </div>
    </div>
    <lists ref="lists" id="lists" :boardid="boardid" class="columns"></lists>
  </div>
</template>
<script>
import lists from "./lists";
import { EventBus } from "./../eventbus.vue";

export default {
  components: {
    lists: lists
  },

  data() {
    return {
      board: "",
      index: "",
      loader: false
    };
  },
  props: {
    boardid: String
  },

  methods: {
    edit() {
      EventBus.$emit("edit", this.board, this.index);
    },

    init(boards) {
      boards.find((element, index) => {
        if (element.id == this.boardid) {
          this.board = boards[index];
          this.index = index;
        }
      });
    },

    edited(board) {
      this.board = board;
      window.history.replaceState("", "", board.slug);
    },

    plus() {
      this.$refs.lists.create();
      this.loader = true;
    },
    listcreated() {
      this.loader = false;
    }
  },

  mounted() {
    EventBus.$on("edited", this.edited);
    EventBus.$on("boards", this.init);
    EventBus.$on("listcreated", this.listcreated);
  }
};
</script>
