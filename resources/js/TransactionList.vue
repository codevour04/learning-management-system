<template>

</template>

<script>
export default {
    name: 'TransactionList',

    data: () => ({
        transaction: {
            number: null,
            customerId: null,
            status: null,
        },
        headers:
          [
            { text: "Name", value: "name", sortable: true},
            { text: "EMAIL", value: "email"},
            { text: "", value: "edit"},
            { text: "", value: "delete"},
            { text: "", value: "add-permission"},
            { text: "", value: "remove-permission"}
        ],
        trasactions: []
    }),

    created () {
      this.fetchTransaction()
    },

    methods: {
      fetchTransaction () {
        this.$http.get('transactions', {
          params: {
            keyword: "",
          }
        })
          .then(response => console.log(response));
      }
    }
}
</script>
