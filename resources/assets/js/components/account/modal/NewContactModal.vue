<template>
    <modal :show="show" header="New Field" ref="modal" @close="close" :errors="errors">        
        <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
            Name
        </label>
        <input class="form-control" type="text" name="name" placeholder="Social Media" v-model="form.newTab">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
            Value
        </label>
        <input class="form-control" type="text" name="name" placeholder="Social Media" v-model="form.newValue">
        <button class="mt-2 bg-brand hover:bg-brand-dark text-white font-bold py-2 px-4 rounded" @click="create"> Create Tab</button>
    </modal>
</template>

<script>
import Form from "../../../class/Form";

export default {
  props: {
    show: { required: true },
    id: { required: true }
  },
  data() {
    return {
      form: new Form({
        name: "",
        mobile_phone: "",
        home_phone: "",
        work_phone: "",
        email: "",
        primary: false
      }),
      errors: null
    };
  },
  methods: {
    close() {
      this.form.reset();
      this.$emit("close");
    },
    create() {
      axios
        .post(`/api/accounts/${this.id}/contacts`, this.form.data())
        .then(response => {
          flash("Contact Created.");
          this.$emit("created", response.data.data);
          this.close();
        })
        .catch(err => {
          this.errors = err.response.data.errors;
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
