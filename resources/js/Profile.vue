<template>
    <v-app id="inspire">
        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Welcome, {{ loggedUser.name }} </v-toolbar-title>
            <v-spacer />
            <v-btn class="text-right" @click="logout">Logout</v-btn>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer">
            <div class="d-flex justify-center my-10" >
                <router-link to="/user">User management</router-link>
            </div>
        </v-navigation-drawer>
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row>
                    <v-col>
                        <v-table style="padding: 30px">
                        <thead>
                            <h2>Permissions:</h2>
                        </thead>
                        <tbody>
                            <ul>
                            <li v-for="permission in loggedUserPermissions" :key="permission">
                                {{ permission }}
                            </li>
                        </ul>
                        </tbody>
                        </v-table>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>

import { mapState } from 'vuex';

export default {
    name: 'Profile',

    data: () => ({
        drawer: false,
        loggedUserPermissions: []
    }),

    mounted () {
        this.getAuthUser();
    },

    computed: {
        ...mapState({
            loggedUser: state => state.user
        }),

        canViewCourses () {
            let canDo = false;

            this.loggedUser.permissions.forEach(permission => {
                if (permission.name == "view courses") {
                    canDo = true;
                }
            });

            return canDo;
        },

        canViewUsers () {
            let canDo = false;

            this.loggedUser.permissions.forEach(permission => {
                if (permission.name == "view users") {
                    canDo = true;
                }
            });

            return canDo;
        },

        canViewRolesAndPermissions () {
            let canDo = false;

            this.loggedUser.permissions.forEach(permission => {
                if (permission.name == "view roles and permissions") {
                    canDo = true;
                }
            });

            return canDo;
        }
    },

    methods: {
        getAuthUser () {
            this.$store.state.user = window.App.user;

            this.getAuthUserPermissions();
        },

        logout () {
            this.$http.get("ajax/logout");
            this.$router.push({ path: '/' });
        },

        getAuthUserPermissions () {
            this.$http.get("ajax/permissions/user/"+this.loggedUser.id)
                .then(response => {
                    this.loggedUserPermissions = response.data

                })
        }
    }
}
</script>
