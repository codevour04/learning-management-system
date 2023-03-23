<template>
    <v-app-bar :elevation="1" class="bg-amber-darken-4">
        <v-app-bar-nav-icon @click='toggleDrawer'></v-app-bar-nav-icon>
        <v-toolbar-title>Welcome, {{ loggedUser.name }} </v-toolbar-title>
        <v-spacer />
        <v-btn class="text-right" @click="logout">Logout</v-btn>
    </v-app-bar>
</template>


<script>

import { mapState } from 'vuex'

export default {
    name: 'AppBar',

    components: {
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
