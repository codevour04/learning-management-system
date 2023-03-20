<template>
  <v-form v-model="valid">
    <v-container>
      <v-row>
        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="customer.firstName"
            :counter="10"
            label="First name"
            required
          />
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="customer.middleName"
            :counter="10"
            label="Middle name"
            required
          />
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="customer.lastName"
            :counter="10"
            label="Last name"
            required
          />
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="customer.address"
            label="Address"
          />
        </v-col>

        <v-col
            cols="12"
            md="4"
        >
            <v-text-field
                v-model="customer.city"
                label="City"
            />
        </v-col>
      </v-row>
      <v-row>
        <v-btn @click="addCustomer">
            Save
        </v-btn>
      </v-row>
    </v-container>
  </v-form>
</template>

<script>
export default {
    name: 'CustomerList',

    data: () => ({
        customer: {
            firstName: null,
            middleName: null,
            lastName: null,
            address: null,
            city: null
        }
    }),

    methods: {
        addCustomer () {
            this.$http.post('customer', this.customer)
                .then((response) => {
                    console.log(response);
                    alert("customer addedd");
                })
        }
    }
}
</script>
