<template>
    <transition name="fade">
    <div v-show="show">
        <div class="fixed z-50 pin overflow-auto bg-smoke-dark flex md:justify-center lg:justify-center" >
            <div class="fixed shadow-inner w-full md:w-1/2 lg:w-1/2 p-8 bg-white md:rounded md:h-auto md:shadow ">
                <div class="w-full border-b-1 h-8">
                    <h2 class=" absolute pin-t pin-l pt-4 pl-4">{{header}}</h2>
                    <span @click="close" class="absolute pin-t pin-r pt-2 px-4">
                        <svg class="h-12 w-12 text-grey hover:text-grey-darkest" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
                <div class="justify-center w-full">
                    <transition name="fade">
                    <div class="bg-red-lightest border-l-4 border-red p-4" role="alert" v-show="errors">
                        <p class="font-bold">Un oh</p>
                        <ul>
                            <li class="list-reset" v-for="(error, index) in errors" :key="index">{{error[0]}}</li>
                        </ul>
                    </div>
                    </transition>
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
    </transition>
</template>

<script>
//  To close this clase simply $emit('close')
export default {
  mounted() {
    document.addEventListener("keydown", e => {
      if (this.show && e.keyCode == 27) {
        this.close();
      }
    });
  },
  props: {
    header: { required: true },
    show: { required: true },
    errors: { required: false }
  },
  methods: {
    close() {
      this.$root.showModal = false;
      this.$emit("close");
    }
  }
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
