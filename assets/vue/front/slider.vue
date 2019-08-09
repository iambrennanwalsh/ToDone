<template>
  <div>
    <h1
      v-text="heading[current % heading.length]"
      class="title has-text-grey-dark"
    ></h1>
    <p v-text="paragraph[current % paragraph.length]" class="subtitle"></p>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      heading: [
        "For you chronic list makers.",
        "Pool party? Lame. Throw a list party.",
        "Todo list? More like to done list."
      ],
      paragraph: [
        "Because orginization is motivation.",
        "Because getting it done is fun.",
        "Knockin out your to do, is the cool thing to do."
      ],
      current: 0,
      timer: null
    };
  },
  mounted: function() {
    this.startRotation();
  },
  methods: {
    startRotation: function() {
      this.timer = setInterval(this.next, 3000);
    },
    next: function() {
      this.current += 1;
    }
  }
};
</script>
