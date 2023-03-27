<template>
    <v-dialog v-model="showModal" width="auto">
        <div class="d-flex justify-center align-center" style="height: 50vh">
            <v-card min-width="400">
                <v-card-text>
                    <v-form
                        @submit.prevent="submit"
                        validate-on="submit"
                    >
                        <v-text-field
                            class="mb-2"
                            label="Name"
                            v-model="form.name"
                        />

                        <v-text-field
                            :error-messages="errors.email"
                            :error="hasError.email"
                            class="mb-2"
                            label="Email"
                            v-model="form.email"
                        />

                        <v-text-field
                            :append-inner-icon="showHidePassword ? 'mdi-eye' : appendIcon"
                            :error-messages="errors.password"
                            :error="hasError.password"
                            :type="showHidePassword ? 'text' : 'password'"
                            @click:append-inner="showHidePassword = !showHidePassword"
                            label="Password"
                            v-model="form.password"
                        />

                        <v-text-field
                            type="password"
                            label="Confirm password"
                            v-model="form.password_confirmation"
                        />

                        <br>

                        <v-btn
                            :loading="loading"
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
    name: 'RegisterForm',

    data () {
        return {
            errors: {
                email: "",
                password: ""
            },
            form: {
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            },
            hasError: {
                email: false,
                password: false
            },
            loading: false,
            showHidePassword: false,
            showModal: false,
        }
    },

    computed: {
        appendIcon () {
            return (this.form.password.length > 0) ? "mdi-eye-off" : "";
        }
    },

    methods: {
        showDialog () {
            this.showModal = true;
        },

        submit () {
            let payload = this.form;
            this.loading = true;

            this.$http.post("/register", payload)
                .then(() => this.$router.push({ path: "/dashboard" }))
                .catch(errors => {
                    this.loading = false;
                    let errorMessages = errors.response.data.errors;
                    this.errors = errorMessages;

                    if (errors.response.data.errors.email) {
                        this.hasError.email = true;
                    }

                    if (errors.response.data.errors.password) {
                        this.hasError.password = true;
                    }
                });
        }
    }
}
</script>
