<template>
    <div class="h-screen">
        <div class="z-30 h-12 bg-grey-light ">
            <ul class="list-reset flex h-full">
                <li class="tab p-3 md:p-2 lg:p-2 xl:p-2" :class="{'tab-active': tab.isActive}"v-for="(tab, index) in tabs" :key="index" @click="selectTab(tab)">
                    <span class="">i</span>
                    <br class="hidden lg:inline md:inline font-hairline"/>
                    <span class="hidden lg:inline md:inline font-hairline">{{tab.name}}</span>
                </li>
            </ul>
        </div>

        <div class="h-screen">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      tabs: []
    };
  },
  mounted() {
    this.tabs = this.$children;
  },
  methods: {
    selectTab(selectedTab) {
      this.tabs.forEach(tab => {
        tab.isActive = tab.name == selectedTab.name;
      });
    }
  }
};
</script>

<style>

</style>
