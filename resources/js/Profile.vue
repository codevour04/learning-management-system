<template>
    <v-app id="inspire">
        <app-bar />
        <side-drawer ref="navDrawer">
            <router-link to="/user"> User management </router-link>
        </side-drawer>
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row>
                    <v-col>
                        <v-list lines="one">
                            <v-list-item
                                v-for="item in loggedInUserPermissions"
                                :key="item.name"
                                :title="item.name"
                            ></v-list-item>
                        </v-list>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>
a {
    color: #ffff;
    text-decoration: none;
}
</style>

<script>

import { mapState } from 'vuex'
import AppBar from './components/AppBar.vue'
import SideDrawer from './components/NavigationDrawer.vue'

export default {
    name: 'Profile',

    components: {
        AppBar,
        SideDrawer
    },

    data () {
        return {
            loggedInUserPermissions: null
        }
    },

    mounted () {
        this.getAuthUserAndPermissions();
    },

    computed: {
        ...mapState({
            loggedUser: state => state.user,
            drawToggle: state => state.drawToggle
        }),

        loggedInUser () {
            return window.App.user;
        },

        canViewCourses () {
            let canDo = false;

            this.loggedUserPermissions.forEach(permission => {
                if (permission.name == "view courses") {
                    canDo = true;
                }
            });

            return canDo;
        },

        canViewUsers () {
            let canDo = false;

            this.loggedUserPermissions.forEach(permission => {
                if (permission.name == "view users") {
                    canDo = true;
                }
            });

            return canDo;
        },

        canViewRolesAndPermissions () {
            let canDo = false;

            this.permissions.forEach(permission => {
                if (permission.name == "view roles and permissions") {
                    canDo = true;
                }
            });

            return canDo;
        }
    },

    methods: {
        logout () {
            this.$http.get("ajax/logout");
            this.$router.push({ path: '/' });
        },

        getAuthUserAndPermissions () {
            this.$http.get("ajax/auth-user")
                .then(response => {

                    this.loggedInUserPermissions = response.data.permissions
                    this.$store.state.user = response.data;
                    window.App.user = response.data;
                })
        },

        toggleDrawer () {
            this.$store.commit('setDrawToggle')
        }
    }
}
</script>
