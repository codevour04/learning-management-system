<template>
 <v-dialog v-model="showModal" width="auto">
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

                    <br>

                    <v-btn
                    block
                    color="blue"
                    size="large"
                    type="submit"
                    variant="elevated"
                    >
                    Save
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
    </v-dialog>
</template>

<script>
export default {
    name: 'AddUserModal',

    emits: ['closeModal'],

    data: () => ({
        form: {
            name: "",
            email: "",
            password: "pass1234",
            password_confirmation: "pass1234"
        },
        showModal: false,
    }),

    methods: {
        showDialog () {
            this.showModal = true;
        },

        submit () {
            let payload = this.form;

            this.$http.post("/user", payload)
            .then(() => {
                this.showModal = false;
                this.$emit("closeModal");
            });
        }
    }
}
</script>
