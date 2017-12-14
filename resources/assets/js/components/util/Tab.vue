<template>
    <div v-show="isActive" class="bg-grey-lighter w-full h-screen p-4 shadow-md">
        <slot></slot>
    </div>
</template>

<script>
export default {
  props: {
    name: { required: true },
    selected: { default: false }
  },
  data() {
    return {
      isActive: false
    };
  },
  mounted() {
    this.isActive = this.selected;
  }
};
</script>

<style>

</style>
