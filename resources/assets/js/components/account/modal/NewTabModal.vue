<template>
    <modal :show="show" header="New Tab" ref="modal" @close="close" :errors="form.errors">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
            Name
        </label>
            <input class="form-control" type="text" name="name" placeholder="Social Media" v-model="form.name">
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
        name: ""
      })
    };
  },
  methods: {
    close() {
      this.$emit("close");
    },
    create() {
      this.form
        .submit("post", `/api/accounts/${this.id}/tabs`)
        .then(response => {
          this.$emit("created", response);
          this.close();
        });
    }
  }
};
</script>

<style>

</style>
