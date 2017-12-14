<template>
<div>
  <transition name="fade">
      <div class="absolute pin-b pin-r  bg-white border-t-4 border-brand-dark rounded-b green-teal-darkest px-4 py-3 shadow-md" role="alert" v-if="show">
    <div class="flex">
      <svg class="h-6 w-6  mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg>
      <div>
        <p class="font-bold">Success!</p>
        <p class="text-sm text-grey">{{body}}</p>
      </div>
    </div>
  </div>
  </transition>
</div>
</template>

<script>
export default {
  props: ["message"],
  created() {
    if (this.message) {
      this.flash(this.message);
    }
    window.events.$on("flash", message => {
      this.flash(message);
    });
  },
  data() {
    return {
      body: "",
      show: false
    };
  },
  methods: {
    flash(message) {
      this.body = message;
      this.show = true;

      this.hide();
    },
    hide() {
      setTimeout(() => {
        this.show = false;
      }, 5000);
    }
  }
};
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0
}
</style>
