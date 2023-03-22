<template>
    <v-app id="inspire">
        <v-app-bar class="bg-amber-darken-4">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Dashboard</v-toolbar-title>
            <v-spacer />
            <v-btn class="text-right" @click="logout">Logout</v-btn>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer">
            <div class="d-flex justify-center my-10">
                <router-link to="/management/profile">Profile</router-link>
            </div>
            <div class="d-flex justify-center my-10">
                <router-link to="/management/user">User management</router-link>
            </div>
        </v-navigation-drawer>
        <v-main>
            <v-container>
                <v-row>
                    <v-col>
                        <router-link to="/management/user">
                            <v-card
                                width="400"
                                title="User management"
                            ></v-card>
                        </router-link>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>
a {
    text-decoration: none;
    text-align: center
}
</style>

<script>
export default {
    name: 'AdminPage',

    data: () => ({
        drawer: false
    }),

    methods: {
        logout () {
            this.$http.get("/logout").then(() => this.$router.push({ path: '/' }));
        }
    }
}
</script>
