<template>
    <v-dialog v-model="showDialog" width="auto">
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
    name: 'EditUserModal',

    data: () => ({
        form: null,
        showDialog: false,
    }),

    methods: {
        showModal(data) {
            this.showDialog = true;
            this.form = data;
        },

        submit () {
            let id = this.form.id;

            this.$http.patch("user/"+id, this.form)
                .then(() => {
                    this.$emit("update-user");
                    this.showDialog = false;
                })
        }
    }
}
</script>
