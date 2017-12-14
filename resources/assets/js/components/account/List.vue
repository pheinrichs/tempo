<template>
    <div class="w-full text-grey-dark max-h-sm flex">
        <div class="w-full md:w-1/4 lg:w-1/4 pl-4 pr-2">
            <div class="w-100 p-2 h-10 bg-grey-lighter mb-4 shadow">
                <div class="w-100 p-4 h-12 bg-grey-light">
                    Tabs
                    <button class="no-underline bg-brand shadow hover:shadow-lg hover:bg-brand-dark text-white py-1 px-2 border-b-2 border-brand-dark rounded text-sm float-left" @click="showTabModal = true">New Tab</button>
                    <new-tab-modal :show="showTabModal" :id="id" @created="addTab" @close="showTabModal = false"></new-tab-modal>
                </div>
            </div>
            <ul class="list-reset inline">
                <li class="w-full appearance-none py-2 px-3 rounded hover:text-grey-darkest" :class="{active: tab.id == selectedTab.id}" v-for="tab of tabs" :key="tab.id" @click="open(tab)">{{tab.name}}</li>
            </ul>
        </div>
        <transition name="component-fade" mode="out-in">
            <div class="w-full md:flex-1 lg:flex-1 border rounded" v-if="tabSelectedActive">
                <div class="w-100 p-4 h-12 bg-grey-light">
                    <h4>{{selectedTab.name}}</h4>
                </div>
                <div class="w-100 p-2 h-10 bg-grey-lighter mb-4 shadow">
                    <new-field-modal :show="showFieldModal" :tab="selectedTab" @created="addField" @close="showFieldModal = false"></new-field-modal>
                    <button @click="showFieldModal = true" class="no-underline bg-brand shadow hover:shadow-lg hover:bg-brand-dark text-white py-1 px-2 border-b-2 border-brand-dark rounded text-sm float-left">
                              + Add Field
                          </button>
                </div>
                <div v-if="fields.length > 0">
                    <edit-field-modal :show="showEditFieldModal" :tab="selectedTab" :field="selectedField" @close="showEditFieldModal = false" @updated="updateField"></edit-field-modal>
                    <div class="rounded shadow bg-white mb-2" v-for="field of fields" :key="field.id">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{field.name}}</div>
                            <p class="text-grey-darker text-base">
                                {{field.value}}
                            </p>
                            <button @click="selectField(field)">
                                Edit Field
                            </button>
                        </div>
                    </div>
                </div>
                <div v-if="fields.length == 0" class="rounded shadow bg-white mb-2">
                    <div class="px-6 py-4">
                        <p class="text-grey-darker text-base">
                            Looks like no fields have been added yet!
                        </p>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
  data() {
    return {
      showTabModal: false,
      showFieldModal: false,
      showEditFieldModal: false,
      tabs: [],
      fields: [],
      tabSelectedActive: false,
      selectedTab: {},
      selectedField: {}
    };
  },
  props: ["id"],
  created() {
    axios.get(`/api/accounts/${this.id}`).then(response => {
      this.tabs = response.data.data.tabs;
      if (this.tabs.length > 0) this.open(this.tabs[0]);
    });
  },
  methods: {
    open(tab) {
      if (tab.id === this.selectedTab.id) return;
      this.selectedTab = tab;
      this.tabSelectedActive = true;
      axios.get(`/api/accounts/${this.id}/tabs/${tab.id}`).then(response => {
        this.fields = response.data.data.fields;
      });
    },
    selectField(field) {
      this.selectedField = field;
      this.showEditFieldModal = true;
    },
    addTab(tab) {
      this.tabs.push(tab);
    },
    addField(field) {
      this.fields.push(field);
    },
    updateField(payload) {
      this.fields.forEach((field, index) => {
        if (payload.id == field.id) {
          this.fields[index] = payload;
        }
      });
    }
  }
};
</script>

<style>

</style>