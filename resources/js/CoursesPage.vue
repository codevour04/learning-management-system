<template>
    <v-app id="inspire">
        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Courses</v-toolbar-title>
            <v-spacer />
            <v-btn class="text-right" @click="logout">Logout</v-btn>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer" temporary>
            <div class="d-flex justify-center my-10">
                <router-link to="/home">Dashboard</router-link>
            </div>
            <div class="d-flex justify-center my-10">
                <router-link to="/user-management">User management</router-link>
            </div>
        </v-navigation-drawer>
        <v-main>
            <v-container>
                <v-row>
                    <v-col>
                        <div class="d-flex justify-center align-center" style="height: 50vh">
                            <h2>Course Page</h2>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: 'CoursesPage',

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
