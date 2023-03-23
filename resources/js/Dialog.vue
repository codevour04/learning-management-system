<template>
 <v-dialog
      v-model="showModal"
      width="auto"
    >
  <div class="d-flex justify-center align-center" style="height: 50vh">
    <v-card min-width="400">
            <v-card-text>
                <v-form
                    validate-on="submit"
                    @submit.prevent="submit"
                >
                    <v-text-field
                        v-model="form.name"
                        class="mb-2"
                        clearable
                        label="Name"
                    />

                    <v-text-field
                        v-model="form.email"
                        :error="hasError.email"
                        :error-messages="errors.email"
                        class="mb-2"
                        clearable
                        label="Email"
                    />

                    <v-text-field
                        v-model="form.password"
                        :error="hasError.password"
                        :error-messages="errors.password"
                        clearable
                        label="Password"
                    />

                    <v-text-field
                        v-model="form.password_confirmation"
                        clearable
                        label="Confirm password"
                    />

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
        errors: {
            email: '',
            password: ''
        },
        hasError: {
            email: false,
            password: false
        }
    }),

    methods: {
        showDialog () {
            this.showModal = true;
        },

        submit () {
            let payload = this.form;

            this.$http.post("/register", payload)
            .then(() => this.$router.push({ path: '/profile' }))
            .catch(errors => {
                let errorMessages = errors.response.data.errors;
                this.errors = errorMessages;

                if (errors.response.data.errors.email) {
                    this.hasError.email = true;
                }

                if (errors.response.data.errors.password) {
                    this.hasError.password = true;
                }
            });

            if (this.hasError.email || this.hasError.password) {
                // do nothing
            } else {

            }
        }
    }
}
</script>
