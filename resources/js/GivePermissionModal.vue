<template>
    <v-dialog v-model="showDialog" width="auto">
        <div class="d-flex justify-center align-center" style="height: 50vh">
            <v-card min-width="400">
                <v-card-title class="text-blue text-center mb-5">
                    {{ modalTitle }} PERMISSION
                </v-card-title>
                <v-card-subtitle>
                    Name: {{ user.name }}
                </v-card-subtitle>
                <v-card-subtitle>
                    Email: {{ user.email }}
                </v-card-subtitle>
                <template v-if="userPermission.length > 0">
                    <v-card-subtitle class="text-blue mt-5">
                        User permissions:
                    </v-card-subtitle>
                    <ul class="permission-list">
                        <v-card-subtitle class="permission" v-for="permission in userPermission" :key="permission">
                        <li>
                            {{ permission }}
                        </li>
                        </v-card-subtitle>
                    </ul>
                </template>
                <template v-else>
                    <v-card-subtitle class="text-red mt-5">
                        User has no permissions
                    </v-card-subtitle>
                </template>
                <v-spacer />
                <v-card-actions>
                    <v-select
                        v-model="permission"
                        :items="permissionTags"
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
import { mapState } from 'vuex';
import * as ACLConstants from './lookups/acl-constants.js';

export default {
    name: 'GivePermissionModal',

    data () {
        return {
            action: "",
            permission: "",
            permissionTags: null,
            showDialog: false,
            user: null,
            userPermission: [],
        }
    },

    watch: {
        loggedUser (user) {
            if (user.hasOwnProperty('permissions')) {
                // this.userPermission = user.permissions;
            }
        },

        showDialog (value) {
            if (!value) {
                this.permission = "";
            }
        }
    },

    computed: {
        ...mapState({
            loggedUser: state => state.user,
        }),

        modalTitle () {
            return this.action.toUpperCase();
        },


    },

    mounted () {
        this.permissionTags = Object.values(ACLConstants)
            .map((permission) => ({
                "title": permission
            }));
    },

    methods: {
        showModal(data, action) {
            this.showDialog = true;
            this.user = data;
            this.action = action;

            this.fetchUserPermissions();
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

        emitEvent () {
            this.$emit("permission-add-remove");
        },

        fetchUserPermissions () {
            this.$http.get("ajax/permissions/user/"+this.user.id)
                .then(response => {
                    this.userPermission = response.data;
                });
        }
    }
}
</script>
