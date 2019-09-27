<template>
  <draggable v-model="lists" @end="sort">
    <div class="lixx column is-4" v-for="(list, index) in lists" :key="list.id">
      <div class="list column is-12 animated fadeInUp" @animationend="animateit">
        <header>
          <p
            v-text="list.name"
            @click="active"
            @keydown.enter.prevent="update(index, $event)"
            @blur="update(index, $event)"
            contenteditable
            spellcheck="false"
          ></p>
          <span
            v-show="!loader"
            @click="remove(index)"
            class="delete head is-pulled-right"
          ></span>
          <span v-show="loader" class="is-loading is-pulled-right"></span>
        </header>
        <list ref="list" :listid="list.id"></list>
        <form
          @submit.prevent="add(index)"
          method="post"
          class="column addtask"
        >
          <div class="field has-addons">
            <div class="control w-100">
              <input
                v-model="card[index]"
                class="input"
                name="task"
                type="text"
                placeholder="Go to grocery store.."
              />
            </div>
            <div class="control">
              <button
                @click.prevent="add(index)"
                type="submit"
                class="addcard button is-primary"
              >
                <span class="fa fa-plus"></span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </draggable>
</template>

<script>
import list from "./list";
import draggable from "vuedraggable";
import { EventBus } from "./../eventbus.vue";

export default {
  components: {
    list: list,
    draggable: draggable
  },

  data() {
    return {
      lists: "",
      loader: false,
      card: [],
    };
  },

  props: {
    boardid: String
  },
  methods: {
    add(index) {
      if (this.card[index] == "") return false;
      let val = index + 1;
      document
        .querySelector(".lixx:nth-child(" + val + ") .addcard")
        .classList.add("is-loading");
      axios
        .post("/api/cards", {
          listId: "/api/lists/" + this.lists[index].id,
          name: this.card[index],
          position: this.$refs.list[index].cards.length,
          status: 0
        })
        .then(response => {
          this.card[index] = "";
          this.$refs.list[index].cards.push(response.data);
          document
            .querySelector(".lixx:nth-child(" + val + ") .addcard")
            .classList.remove("is-loading");
          document.querySelector(
            ".lixx:nth-child(" + val + ") form .input"
          ).value = "";
        });
    },
    create() {
      axios
        .post("/api/lists", {
          boardId: "/api/boards/" + this.boardid,
          name: "New List",
          position: this.lists.length
        })
        .then(response => {
          this.lists.push(response.data);
          EventBus.$emit("listcreated");
        });
    },

    active(event) {
      event.target.classList.add("active");
    },

    update(index, event) {
      event.target.blur();
      event.target.classList.remove("active");
      let src = event.target.innerText;
      if (src != this.lists[index].name) {
        this.lists[index].name = src;
        this.loader = true;
        axios
          .put("/api/lists/" + this.lists[index].id, { name: src })
          .then(response => {
            this.loader = false;
          });
      }
    },

    remove(index) {
      this.loader = true;
      axios.delete("/api/lists/" + this.lists[index].id).then(response => {
        this.$delete(this.lists, index);
        this.loader = false;
        this.sort();
      });
    },

    sort() {
      this.lists.forEach((element, index) => {
        axios.put("/api/lists/" + this.lists[index].id, {
          position: index
        });
      });
    },
    animateit(event) {
      event.target.classList.remove('animated');
    }
  },

  mounted: function() {
    axios.get("/api/boards/" + this.boardid + "/lists").then(response => {
      this.lists = response.data;
      this.lists.forEach(item => {
        this.card.push("");
      });
    });
  }
};
</script>
