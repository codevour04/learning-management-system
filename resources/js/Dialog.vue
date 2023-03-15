<template>
 <v-dialog
      v-model="showModal"
      width="auto"
    >
  <div class="d-flex justify-center align-center" style="height: 50vh">
    <v-card min-width="400">
            <v-card-text>
                <v-form
                    @submit.prevent="submit"
                >
                <v-text-field
                    v-model="form.name"
                    class="mb-2"
                    clearable
                    label="Name"
                    ></v-text-field>

                    <v-text-field
                    v-model="form.email"
                    class="mb-2"
                    clearable
                    label="Email"
                    ></v-text-field>

                    <v-text-field
                    v-model="form.password"
                    clearable
                    label="Password"
                    ></v-text-field>

                    <v-text-field
                    v-model="form.password_confirmation"
                    clearable
                    label="Confirm password"
                    ></v-text-field>

                    <br>

                    <v-btn
                    block
                    color="blue"
                    size="large"
                    type="submit"
                    variant="elevated"
                    >
                    Register
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
    </v-dialog>
</template>

<script>
export default {
    name: "Modal",

    data: () => ({
        form: {
            name: "",
            email: "",
            password: "",
            password_confirmation: ""
        },
        showModal: false,
    }),

    methods: {
        showDialog () {
            this.showModal = true;
        },

        submit () {
            let payload = this.form;

            this.$http.post("/register", payload)
            .then(response => console.log(response));
        }
    }
}
</script>
