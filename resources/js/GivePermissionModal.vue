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
                <v-card-title>
                    User permissions:
                </v-card-title>
                <ul class="permission-list">
                    <v-card-title class="permission" v-for="permission in userPermission" :key="permission.id">
                    <li>
                        {{ permission.name }}
                    </li>
                    </v-card-title>
                </ul>
                <v-spacer></v-spacer>
                <v-card-actions>
                    <v-select
                        v-model="permission"
                        :items="permissions"
                        label="Select a permission"
                    />

                </v-card-actions>
                <v-card-actions>
                    <v-btn
                        variant="outlined"
                        color="red"
                        size="large"
                        @click="showDialog = !showModal"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                        variant="outlined"
                        color="blue"
                        size="large"
                        @click="givePermission"
                        v-if="action == 'add'"
                    >
                        Add
                    </v-btn>
                    <v-btn
                        variant="outlined"
                        color="blue"
                        size="large"
                        @click="removePermission"
                        v-if="action == 'remove'"
                    >
                        Remove
                    </v-btn>
                </v-card-actions>
            </v-card>
        </div>
    </v-dialog>
</template>

<style scoped>
.permission-list li {
    margin-left: 50px;
}
</style>

<script>
export default {
    name: 'GivePermissionModal',

    data: () => ({
        user: null,
        showDialog: false,
        permissions: null,
        permission: "",
        action: "",
        userPermission: null
    }),

    created () {
        this.fetchPermissions();
    },

    methods: {
        showModal(data, action) {
            this.showDialog = true;
            this.user = data;
            this.action = action;
            // this.fetchUserPermission()
        },

        givePermission () {
            let data = {
                action: 'add',
                permission_name: this.permission
            }

            this.$http.put('/ajax/user/' + this.user.id + '/permission', data)
                .then(() => {
                    this.showDialog = false;
                    this.emitEvent();
                })
        },

        removePermission () {
            let data = {
                action: 'remove',
                permission_name: this.permission
            }

            this.$http.put('/ajax/user/' + this.user.id + '/permission', data)
                .then(() => {
                    this.showDialog = false;
                    this.emitEvent();
                })
        },

        fetchPermissions () {
            this.$http.get("/ajax/permissions")
                .then(response => {
                    this.permissions = response.data.map((permission) => ({
                            "title": permission.name
                    }));
                })
        },

        emitEvent () {
            this.$emit("permission-add-remove");
        },

        fetchUserPermission () {
            this.$http.get("ajax/permissions/user/"+this.user.id)
                .then(response => {
                    console.log(response);
                    this.userPermission = response.data

                })
        }
    }
}
</script>
