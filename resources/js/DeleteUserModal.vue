<template>
    <v-dialog v-model="showDialog" width="auto">
        <div class="d-flex justify-center align-center" style="height: 50vh">
            <v-card min-width="400">
                <v-card-title>
                    Name: {{ user.name }}
                </v-card-title>
                <v-card-title>
                    Email: {{ user.email }}
                </v-card-title>
                <v-spacer></v-spacer>
                <v-card-text color="red">
                    <h1>Are you sure you want to delete this user?</h1>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        variant="outlined"
                        color="blue"
                        size="large"
                        @click="showDialog = !showDialog"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                        variant="outlined"
                        color="red"
                        size="large"
                        @click="deleteUser"
                    >
                        Proceed
                    </v-btn>
                </v-card-actions>
            </v-card>
        </div>
    </v-dialog>
</template>

<script>
export default {
    name: 'DeleteUserModal',

    data: () => ({
        user: null,
        showDialog: false,
    }),

    methods: {
        showModal(data) {
            this.showDialog = true;
            this.user = data;
        },

        deleteUser () {
            let id = this.user.id;

            this.$http.delete("user/"+id)
                .then(() => {
                    this.$emit("delete-user");
                    this.showDialog = false;
                })
        }
    }
}
</script>
