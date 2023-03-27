<template>
    <div class="d-flex justify-center align-center" style="height: 70vh">
        <v-card min-width="400">
            <v-card-text>
                <v-form @submit.prevent="login">
                    <v-text-field
                        :error-messages="errorMessage"
                        :error="hasError"
                        class="mb-2"
                        label="Email or username"
                        v-model="form.email"
                    ></v-text-field>

                    <v-text-field
                        :append-inner-icon="showHidePassword ? 'mdi-eye' : appendIcon"
                        :type="showHidePassword ? 'text' : 'password'"
                        @click:append-inner="showHidePassword = !showHidePassword"
                        label="Password"
                        v-model="form.password"
                    ></v-text-field>

                    <br>

                    <v-btn
                        :loading="loading"
                        block
                        color="blue"
                        size="large"
                        type="submit"
                        variant="elevated"
                    >
                        Sign In
                    </v-btn>
                    <!-- TO DO -->
                    <!-- <div class="d-flex justify-center mt-5">
                        <a href="">Forgot passowrd?</a>
                    </div> -->
                </v-form>
                <v-divider class="my-5" />
                <v-btn
                    @click="showDialog"
                    block
                    color="success"
                    size="large"
                    type="submit"
                    variant="elevated"
                >
                    Register
                </v-btn>
            </v-card-text>
        </v-card>
    </div>
    <register-form ref="modal" />
</template>

<script>
import RegisterForm from './RegisterForm.vue'

  export default {
    name: 'Login',

    components: {
        RegisterForm,
    },

    data () {
        return {
            errorMessage: "",
            form : {
                email: "",
                password: ""
            },
            hasError: false,
            loading: false,
            showHidePassword: false,
        }
    },

    computed: {
        appendIcon () {
            return (this.form.password.length > 0) ? "mdi-eye-off" : "";
        }
    },

    methods: {
        showDialog () {
            this.$refs.modal.showDialog();
        },

        login () {
            let payload = this.form;
            this.loading = true;

            this.$http.post("/login", payload)
                .then(response => {
                    if (response.status == 200) {
                        this.$router.push({ path: "/dashboard" });
                    }
                })
                .catch(() => {
                    this.loading = false;
                    this.hasError = true;
                    this.errorMessage = "The email or password is incorrect"
                });
        },
    }
  }
</script>
