<template>
    <v-app id="inspire">
        <v-app-bar :elevation="1" class="bg-amber-darken-4">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Welcome, {{ loggedUser.name }} </v-toolbar-title>
            <v-spacer />
            <v-btn class="text-right" @click="logout">Logout</v-btn>
        </v-app-bar>
        <v-navigation-drawer class="bg-amber-darken-4" v-model="drawer">
            <div class="d-flex justify-center my-10">
                <router-link to="/home">Dashboard</router-link>
            </div>
        </v-navigation-drawer>
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
                        <v-btn @click="fetchUser">
                            Search
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row>
                    <!-- <v-col>
                    <v-table>
                        <v-spacer></v-spacer>
                        <thead>
                            <tr>
                                <template v-for="(header, index) in users" :key="index">
                                    <th class="text-left" v-if="index == 0"> Name </th>
                                    <th class="text-left" v-else-if="index == 1"> Email </th>
                                </template>
                            </tr>
                        </thead>
                        <tbody class="user-list">
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
                                <td
                                    @click="openPermissionModal(item, 'remove')"
                                    v-if="canGivePermissionUser && item.permissions.length > 0">
                                    <v-btn color="green">Remove Permission</v-btn>
                                </td>
                                <td v-else>
                                    <span>
                                        This user has no permissions
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                        </v-table>
                    </v-col> -->
                       <v-col>
                            <EasyDataTable
                                alternating
                                :headers="headers"
                                :items="users"
                            >
                                <template #item-edit="item" >
                                    <v-btn
                                        class="my-5"
                                        color="green"
                                        @click="updateUser(item)"
                                        v-if="canUpdateUser"
                                        >
                                        Edit
                                    </v-btn>
                                </template>
                                <template #item-delete="item" >
                                    <v-btn
                                        color="red"
                                        @click="showConfirmModal(item)"
                                        v-if="canDeleteUser"
                                    >
                                        Delete
                                    </v-btn>
                                </template>
                                <template #item-add-permission="item" >
                                    <v-btn
                                        color="yellow"
                                        @click="openPermissionModal(item, 'add')"
                                        v-if="canGivePermissionUser"
                                    >
                                        Give Permission
                                    </v-btn>
                                </template>
                                <template #item-remove-permission="item" >
                                    <v-btn
                                        color="green"
                                        @click="openPermissionModal(item, 'remove')"
                                        v-if="canGivePermissionUser && item.permissions.length > 0"
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
                        v-if="canAddUser"
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
import AddUserModal from './AddUserModal.vue';
import EditUserModal from './EditUserModal.vue';
import GivePermissionModal from './GivePermissionModal.vue';
import SwalMessageMixin from './mixins/SwalMessageMixin';

export default {
    name: 'DataTable',

    components: {
        AddUserModal,
        EditUserModal,
        GivePermissionModal,
    },

    mixins: [SwalMessageMixin],

    data: () => ({
        drawer: false,
        loading: false,
        users: [],
        swalMessage: "",
        keyword: "",
        headers:
        [
            { text: "Name", value: "name", sortable: true},
            { text: "EMAIL", value: "email"},
            { text: "", value: "edit"},
            { text: "", value: "delete"},
            { text: "", value: "add-permission"},
            { text: "", value: "remove-permission"}
        ],
        }),

    created() {
        this.getAuthUser();
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
            this.$http.get('fetch-user', {
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
                    this.$router.push({ path: '/profile' });
                }
            });
        },

        showSuccessMessage() {
            this.swalMixinSuccessMessage(this.swalMessage)
            this.fetchUser()
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
        },

        deleteUser (user) {
            let id = user.id;

            this.$http.delete("user/"+id)
                .then(() => {
                    this.swalMessage = 'User has been deleted';
                    this.showSuccessMessage();
                    this.fetchUser();
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

        getAuthUser () {
            this.$http.get('auth-user')
                .then(response => {
                    this.$store.state.user = response.data.user
                })
        },
    }
}
</script>
