<template>
    <div class="w-full text-grey-dark max-h-sm overflow-y-scroll">
        <table class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full text-left table-collapse">
            <thead class="">
                <tr class="">
                    <th class="text-sm font-semibold text-grey-darker p-2 bg-brand-lightest">ID</th>
                    <th class="text-sm font-semibold text-grey-darker p-2 bg-brand-lightest">Name</th>
                    <th class="text-sm font-semibold text-grey-darker p-2 bg-brand-lightest">Address</th>
                    <th class="text-sm font-semibold text-grey-darker p-2 bg-brand-lightest">Postal</th>
                    <th class="text-sm font-semibold text-grey-darker p-2 bg-brand-lightest">City</th>
                    <th class="text-sm font-semibold text-grey-darker p-2 bg-brand-lightest">Country</th>
                </tr>
            </thead>
            <tbody class="align-baseline">
                <tr v-for="account in accounts" v-bind:key="account.id">
                    <td class="table-item lg:whitespace-normal">{{account.id}}</td>
                    <td class="table-item lg:whitespace-normal"><a class="text-blue-dark no-underline" href="#" @click.prevent="load_account(account.id)">{{account.name}}</a></td>
                    <td class="table-item lg:whitespace-normal">{{account.address}}</td>
                    <td class="table-item lg:whitespace-normal">{{account.postal}}</td>
                    <td class="table-item lg:whitespace-normal">{{account.city}}</td>
                    <td class="table-item lg:whitespace-normal">{{account.country}}</td>
                </tr>
            </tbody>
        </table>
  </div>
</template>

<script>
export default {
  mounted() {
    axios
      .get("/api/accounts")
      .then(response => (this.accounts = response.data.data));
  },
  data() {
    return {
      accounts: []
    };
  },

  methods: {
    load_account: function(id) {
      console.log("test");
      window.location.href = `/accounts/${id}`;
    }
  }
};
</script>

<style>

</style>
