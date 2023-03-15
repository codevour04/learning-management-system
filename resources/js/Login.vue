<template>
    <div class="d-flex justify-center align-center" style="height: 50vh">
    <v-card min-width="400">
            <v-card-text>
                <v-form
                    @submit.prevent="login"
                >
                    <v-text-field
                    v-model="form.email"
                    class="mb-2"
                    clearable
                    label="Email or username"
                    ></v-text-field>

                    <v-text-field
                    v-model="form.password"
                    clearable
                    label="Password"
                    ></v-text-field>

                    <br>

                    <v-btn
                    block
                    color="blue"
                    size="large"
                    type="submit"
                    variant="elevated"
                    >
                    Sign In
                    </v-btn>
                    <div class="d-flex justify-center mt-5">
                        <a href="">Forgot passowrd?</a>
                    </div>
                </v-form>
                <v-divider class="my-5"></v-divider>
                    <v-btn
                    block
                    color="success"
                    size="large"
                    type="submit"
                    variant="elevated"
                    @click="showDialog"
                    >
                    Register
                </v-btn>
            </v-card-text>
        </v-card>
    </div>
    <modal ref="modal"></modal>
</template>

<script>
import Modal from './Dialog.vue'

  export default {
    name: 'Login',

    components: {
        Modal,
    },

    data: () =>
        ({
            form : {
                email: "",
                password: ""
            }
        }),

    methods: {
        showDialog () {
            this.$refs.modal.showDialog();
        },

        login () {
            let payload = this.form;

            this.$http.post("/login", payload)
            .then(response => {
                if (response.status == 200) {
                    this.$router.push({ path: '/profile' });
                }
            });
        }
    }
  }
</script>
