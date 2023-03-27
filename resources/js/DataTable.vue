<template>
    <v-app id="inspire">
        <app-bar />
        <side-drawer ref="navDrawer">
            <router-link to="/dashboard"> Dashboard </router-link>
        </side-drawer>
        <v-main class="bg-grey-lighten-1">
            <v-container fluid class="elevation-2">
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="keyword"
                            label="Search"
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-btn @click="fetchUsers">
                            Search
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row>
                       <v-col>
                            <EasyDataTable
                                alternating
                                :headers="headers"
                                :items="users"
                            >
                                <template #item-edit="item" v-if="hasPermissions">
                                    <v-btn
                                        class="my-5"
                                        color="green"
                                        @click="updateUser(item)"
                                        v-if="canDo(permissionTags.UPDATE_USERS)"
                                        >
                                        Edit
                                    </v-btn>
                                </template>
                                <template #item-delete="item" >
                                    <v-btn
                                        color="red"
                                        @click="showConfirmModal(item)"
                                        v-if="canDo(permissionTags.DELETE_USERS)"
                                    >
                                        Delete
                                    </v-btn>
                                </template>
                                <template #item-add-permission="item" >
                                    <v-btn
                                        color="yellow"
                                        @click="openPermissionModal(item, 'add')"
                                        v-if="canDo(permissionTags.GIVE_PERMISSION_USERS)"
                                    >
                                        Give Permission
                                    </v-btn>
                                </template>
                                <template #item-remove-permission="item" >
                                    <v-btn
                                        color="green"
                                        @click="openPermissionModal(item, 'remove')"
                                        v-if="canDo(permissionTags.GIVE_PERMISSION_USERS)
                                            && item.permissions.length > 0"
                                    >
                                        Remove Permission
                                    </v-btn>
                                    <span v-else>
                                        This user has no permissions
                                    </span>
                                </template>
                            </EasyDataTable>
                       </v-col>
                </v-row>
                <v-row>
                    <v-btn
                        class="ml-3 mb-3"
                        color="green"
                        @click="openModal"
                        v-if="canDo(permissionTags.ADD_USERS)"
                    >
                        Add User
                    </v-btn>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
    <add-user-modal ref="addModal" @closeModal="showSuccessMessage"></add-user-modal>
    <edit-user-modal ref="editModal" @updateUser="showSuccessMessage"></edit-user-modal>
    <give-permission-modal ref="permissionModal" @permission-add-remove="showSuccessMessage"></give-permission-modal>
</template>

<style scoped>
a {
    color: #ffff;
    text-decoration: none;
}

.user-list tr:nth-child(odd) {
    background-color: #80808042;
}
</style>

<script>

import { mapState } from 'vuex';
import * as ACLConstants from './lookups/acl-constants';
import AddUserModal from './AddUserModal.vue';
import AppBar from './components/AppBar.vue';
import EditUserModal from './EditUserModal.vue';
import GivePermissionModal from './GivePermissionModal.vue';
import SideDrawer from './components/NavigationDrawer.vue';
import SwalMessageMixin from './mixins/SwalMessageMixin';

export default {
    name: 'DataTable',

    components: {
        AppBar,
        AddUserModal,
        EditUserModal,
        GivePermissionModal,
        SideDrawer
    },

    mixins: [SwalMessageMixin],

    data: () => ({
        drawer: false,
        headers:
        [
            { text: "Name", value: "name", sortable: true},
            { text: "EMAIL", value: "email"},
            { text: "", value: "edit"},
            { text: "", value: "delete"},
            { text: "", value: "add-permission"},
            { text: "", value: "remove-permission"}
        ],
        keyword: "",
        loading: false,
        loggedUserPermissions: [],
        permissionTags: null,
        swalMessage: "",
        users: [],
        hasPermissions: false,

    }),

    watch: {
        user (user) {
            if (user.hasOwnProperty('permissions')) {
                this.hasPermissions = true;
            }
        }
    },

    created() {
        this.fetchUsers();

        this.permissionTags = ACLConstants;
    },

    computed: {
        ...mapState({
            user: state => state.user,
        }),
    },

    methods: {
        fetchUsers () {
            this.$http.get('ajax/users', {
                params: {
                    keyword: this.keyword
                }
            })
            .then(response => {
                if (response.status == 200) {
                    this.users = response.data;
                }
            })
            .catch(error => {
                if (error.request.status == 403) {
                    this.$router.push({ path: '/dashboard' });
                }
            });
        },

        showSuccessMessage() {
            this.swalMixinSuccessMessage(this.swalMessage)
            this.fetchUsers()
        },

        readUser (user) {
            this.swalMixinbasicMessage({
                html: `<h4 style="text-align: left">name: ${user.name} </br> email: ${user.email} </h4>`,
                confirmButtonColor: '#3085d6',
            })
        },

        updateUser (user) {
            this.swalMessage = 'User has been updated';
            this.$refs.editModal.showModal(user);
        },

        openModal () {
            this.swalMessage = 'User has been added';
            this.$refs.addModal.showDialog();
        },

        resetData() {
            this.users = null;
            this.fetchUsers();
        },

        showConfirmModal (user) {
            let config = {
                html: `<h4>Email: ${user.email} </h4>`,
                title: 'Are you sure you want to delete the user?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }

            this.$swal.fire(config).then((result) => {
                if (result.isConfirmed) {
                    this.deleteUser(user)
                }
            })
        },

        deleteUser (user) {
            let id = user.id;

            this.$http.delete("/ajax/user/"+id)
                .then(() => {
                    this.swalMessage = 'User has been deleted';
                    this.showSuccessMessage();
                    this.fetchUsers();
                })
        },

        logout () {
            this.$http.get("/logout").then(() => this.$router.push({ path: '/' }));
        },

        openPermissionModal (user, action) {
            let actionWord = (action == 'add') ? 'added' : 'removed';

            this.swalMessage = 'Permission has been ' + actionWord;
            this.$refs.permissionModal.showModal(user, action);
        },

        canDo (action) {
            let canDo = false;

            this.user.permissions.forEach(permission => {
                if (permission.name === action) {
                    canDo = true;
                }
            });

            return canDo;
        },
    }
}
</script>
