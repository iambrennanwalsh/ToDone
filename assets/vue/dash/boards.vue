<template>
  <div>
    <div class="columns">
      <div class="column p-left-0 p-right-0">
        <button
          @click="create"
          class="button is-primary is-inverted is-pulled-right"
        >
          <span class="fa fa-plus m-left-0"></span> Add Board
        </button>
        <h1 class="title has-text-grey-dark">Boards</h1>
      </div>
    </div>
    <div class="columns wrapem">
      <div
        v-for="(board, index) in $root.boards"
        class="board column box is-6 animated fadeInUp"
      >
        <button
          @click="del(board, index)"
          class="delete is-pulled-right"
        ></button>
        <span
          @click="edit(board, index)"
          class="fa fa-edit editbutton is-pulled-right"
        ></span>
        <p class="is-size-4 m-bottom-10">
          <a
            v-text="board.name"
            class="has-text-info"
            :href="'/board/' + board.slug"
          ></a>
        </p>
        <p class="m-bottom-10 has-text-dark" v-text="board.description"></p>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "./../eventbus.vue";
export default {
  methods: {
    create() {
      EventBus.$emit("create");
    },
    edit(board, index) {
      EventBus.$emit("edit", board, index);
    },
    del(board, index) {
      EventBus.$emit("delete", board, index);
    }
  }
};
</script>
