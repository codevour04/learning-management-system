<template>
    <v-app id="inspire">
        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Welcome, {{ loggedUser.name }} </v-toolbar-title>
            <v-spacer />
            <v-btn class="text-right" @click="logout">Logout</v-btn>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer">
            <div class="d-flex justify-center my-10">
                <router-link to="/home">Dashboard</router-link>
            </div>
        </v-navigation-drawer>
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row>
                    <v-col>
                    <v-table>
                        <thead>
                            <tr>
                                <template v-for="(header, index) in users" :key="index">
                                    <th class="text-left" v-if="index == 0"> Name </th>
                                    <th class="text-left" v-else-if="index == 1"> Email </th>
                                    <th class="text-left" v-else></th>
                                </template>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in users" :key="item.name">
                                <td>{{ item.name }}</td>
                                <td>{{ item.email }}</td>
                                <td @click="readUser(item)">
                                    <v-btn color="blue">Read</v-btn>
                                </td>
                                <td @click="updateUser(item)" v-if="canUpdateUser">
                                    <v-btn color="green">Edit</v-btn>
                                </td>
                                <td @click="showConfirmModal(item)" v-if="canDeleteUser">
                                    <v-btn color="red">Delete</v-btn>
                                </td>
                                <td @click="openPermissionModal(item, 'add')" v-if="canGivePermissionUser">
                                    <v-btn color="yellow">Give Permission</v-btn>
                                </td>
                                <td @click="openPermissionModal(item, 'remove')" v-if="canGivePermissionUser">
                                    <v-btn color="green">Remove Permission</v-btn>
                                </td>
                            </tr>
                        </tbody>
                        </v-table>
                    </v-col>
                </v-row>
                <v-row>
                    <v-btn
                        class="ml-3 mb-3"
                        color="green"
                        @click="openModal"
                        v-if="canAddUser"
                    >
                        Add User
                    </v-btn>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
    <add-user-modal ref="addModal" @closeModal="resetData"></add-user-modal>
    <edit-user-modal ref="editModal" @updateUser="resetData"></edit-user-modal>
    <give-permission-modal ref="permissionModal"></give-permission-modal>
</template>

<script>

import AddUserModal from './AddUserModal.vue';
import EditUserModal from './EditUserModal.vue';
import GivePermissionModal from './GivePermissionModal.vue';
import SwalMessageMixin from './mixins/SwalMessageMixin';
import { mapState } from 'vuex';

export default {
    name: 'DataTable',

    components: {
        AddUserModal,
        EditUserModal,
        GivePermissionModal,
    },

    mixins: [SwalMessageMixin],

    data: () => ({
        users: [],
        drawer: false,
        loading: false,

    }),

    created() {
        this.fetchUser();
    },

    computed: {
        ...mapState({
            loggedUser: state => state.user,
        }),

        canDeleteUser () {
            let canDo = false;

            this.loggedUser.permissions.forEach(permission => {
                if (permission.name === "delete users") {
                    canDo = true;
                }
            });

            return canDo;
        },

        canAddUser () {
            let canDo = false;

            this.loggedUser.permissions.forEach(permission => {
                if (permission.name === "add users") {
                    canDo = true;
                }
            });

            return canDo;
        },

        canEditUser () {
            let canDo = false;

            this.loggedUser.permissions.forEach(permission => {
                if (permission.name === "edit users") {
                    canDo = true;
                }
            });

            return canDo;
        },

        canUpdateUser () {
            let canDo = false;

            this.loggedUser.permissions.forEach(permission => {
                if (permission.name === "update users") {
                    canDo = true;
                }
            });

            return canDo;
        },

        canGivePermissionUser () {
            let canDo = false;

            this.loggedUser.permissions.forEach(permission => {
                if (permission.name === "give permission users") {
                    canDo = true;
                }
            });

            return canDo;
        },
    },

    methods: {
        fetchUser () {
            this.$http.get('/user').then(response => {
                if (response.status == 200) {
                    this.users = response.data;
                }
            })
            .catch(error => {
                if (error.request.status == 403) {
                    this.$router.push({ path: '/profile' });
                }
            });
        },

        readUser (user) {
            this.basicAlertMessage({
                html: `<h4 style="text-align: left">name: ${user.name} </br> email: ${user.email} </h4>`,
                confirmButtonColor: '#3085d6',
            })
        },

        updateUser (user) {
            this.$refs.editModal.showModal(user);
        },

        openModal () {
            this.$refs.addModal.showDialog();
        },

        resetData() {
            this.users = null;
            this.fetchUser();
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

            // this.$refs.confirmModal.showModal(item);
        },

        deleteUser (user) {
            let id = user.id;

            this.$http.delete("user/"+id)
                .then(() => {
                    this.successAlertMessage('User has been deleted')
                    this.resetData()
                })
        },

        logout () {
            this.$http.get("/logout").then(() => this.$router.push({ path: '/' }));
        },

        openPermissionModal (user, action) {
            this.$refs.permissionModal.showModal(user, action);
        },
    }
}
</script>
