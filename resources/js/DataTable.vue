<template>
    <v-app id="inspire">
        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Users</v-toolbar-title>
            <v-spacer />
            <v-btn class="text-right" @click="logout">Logout</v-btn>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer" temporary>
            <div class="d-flex justify-center my-10">
                <router-link to="/home">Dashboard</router-link>
            </div>
        </v-navigation-drawer>
        <v-main class="bg-grey-lighten-2">
            <v-container class="bg-surface-variant">
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
                                <td @click="updateUser(item)">
                                    <v-btn color="green">Edit</v-btn>
                                </td>
                                <td @click="showConfirmModal(item)">
                                    <v-btn color="red">Delete</v-btn>
                                </td>
                                <td @click="openPermissionModal(item, 'add')">
                                    <v-btn color="yellow">Give Permission</v-btn>
                                </td>
                                <td @click="openPermissionModal(item, 'remove')">
                                    <v-btn color="green">Remove Permission</v-btn>
                                </td>
                            </tr>
                        </tbody>
                        </v-table>
                    </v-col>
                </v-row>
                <v-row>
                    <v-btn class="ml-3 mb-3" color="green" @click="openModal">Add User</v-btn>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
    <add-user-modal ref="addModal" @closeModal="resetData"></add-user-modal>
    <read-user-modal ref="readModal"></read-user-modal>
    <edit-user-modal ref="editModal" @updateUser="resetData"></edit-user-modal>
    <delete-user-modal ref="confirmModal" @deleteUser="resetData"></delete-user-modal>
    <give-permission-modal ref="permissionModal"></give-permission-modal>
</template>

<script>

import AddUserModal from './AddUserModal.vue';
import ReadUserModal from './ReadUserModal.vue';
import EditUserModal from './EditUserModal.vue';
import DeleteUserModal from './DeleteUserModal.vue';
import GivePermissionModal from './GivePermissionModal.vue';

export default {
    name: 'DataTable',

    components: {
        AddUserModal,
        ReadUserModal,
        EditUserModal,
        DeleteUserModal,
        GivePermissionModal
    },

    data: () => ({
        users: [],
        drawer: false,
        loading: false,

    }),

    created() {
        this.fetchUser();
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
            this.$refs.readModal.showDialog(user);
        },

        updateUser (user) {
            this.$refs.editModal.showModal(user);
        },

        deleteUser (user) {
            console.log(user);
        },

        openModal () {
            this.$refs.addModal.showDialog();
        },

        resetData() {
            this.users = null;
            this.fetchUser();
        },

        showConfirmModal (item) {
            this.$refs.confirmModal.showModal(item);
        },

        logout () {
            this.$http.get("/logout").then(() => this.$router.push({ path: '/' }));
        },

        openPermissionModal (user, action) {
            this.$refs.permissionModal.showModal(user, action);
        }
    }
}
</script>
