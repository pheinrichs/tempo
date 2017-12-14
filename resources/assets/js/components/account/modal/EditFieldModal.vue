<template>
    <modal :show="show" header="New Field" ref="modal" @close="close" :errors="form.errors">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
            Name
        </label>
        <input class="form-control" type="text" name="name" placeholder="Social Media" v-model="form.name">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
            Value
        </label>
        <input class="form-control" type="text" name="name" placeholder="Social Media" v-model="form.value">
        <button class="mt-2 bg-brand hover:bg-brand-dark text-white font-bold py-2 px-4 rounded" @click="create"> Update Tab</button>
    </modal>
</template>

<script>
import Form from "../../../class/Form";

export default {
  props: {
    show: { required: true },
    tab: { required: true },
    field: { required: true }
  },
  data() {
    return {
      form: new Form(this.field)
    };
  },
  watch: {
    "field.name": function(val) {
      this.form.name = val;
    },
    "field.value": function(val) {
      this.form.value = val;
    }
  },
  mounted() {
    console.log(this.form, this.field);
  },
  methods: {
    close() {
      this.form.reset();
      this.$emit("close");
    },
    create() {
      this.form
        .submit(
          "patch",
          `/api/accounts/${this.tab.account_id}/tabs/${this.tab
            .id}/fields/${this.field.id}`
        )
        .then(response => {
          console.log(response);
          flash("Field updated!");
          this.$emit("updated", response);
          this.close();
        });
    }
  }
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
</style>
