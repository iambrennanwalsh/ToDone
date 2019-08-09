<template>
  <ul class="list-group column is-12">
    <draggable v-model="cards" group="cards" @end="sort">
      <li
        v-for="(card, index) in cards"
        v-bind:class="{ greenit: card.status != 0 }"
        class="task has-text-dark animated fadeIn"
      >
        <label @click="checkit(index)">
          <span
            v-bind:class="{ 'fa-check': card.status != 0 }"
            class="check fa m-left-0"
          ></span>
          <span
            v-bind:class="{ underline: card.status != 0 }"
            class="taskname m-left-20"
            v-text="card.name"
          ></span>
        </label>
        <span @click="del(index, $event)" class="delete is-pulled-right"></span>
      </li>
    </draggable>
  </ul>
</template>

<script>
import draggable from "vuedraggable";
export default {
  components: {
    draggable: draggable
  },
  data: function() {
    return {
      cards: ""
    };
  },
  props: {
    listid: Number
  },

  methods: {
    checkit(index) {
      this.cards[index].status = this.cards[index].status == 1 ? 0 : 1;
      axios.put("/api/cards/" + this.cards[index].id, {
        status: this.cards[index].status
      });
    },
    del(index, event) {
      event.target.classList.add("is-loading");
      event.target.classList.remove("delete");
      axios.delete("/api/cards/" + this.cards[index].id).then(response => {
        this.$delete(this.cards, index);
        this.sort();
      });
    },
    sort() {
      this.cards.forEach((element, index) => {
        axios.put("/api/cards/" + this.cards[index].id, {
          position: index
        });
      });
    }
  },

  mounted() {
    axios.get("/api/lists/" + this.listid + "/cards").then(response => {
      this.cards = response.data;
    });
  }
};
</script>
