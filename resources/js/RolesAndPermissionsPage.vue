<template>
    <v-app id="inspire">
        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Permissions</v-toolbar-title>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer">
            <div class="d-flex justify-center my-10">
                <router-link to="/home">Dashboard</router-link>
            </div>
        </v-navigation-drawer>
        <v-main>
            <v-container>
                <v-row>
                    <v-col>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: 'RolesAndPermissionsPage',

    data: () => ({
        drawer: false,
        permissions: null,
        headers:
        [
            {
                label: "NAMES",
            }
        ],
    }),

    created() {
        this.fetchPermissions();
    },

    methods: {
        fetchPermissions () {
            this.$http.get("/roles-and-permissions")
                .then(response => {
                    this.permissions = response.data
                })
                .catch(error => {
                    if (error.request.status == 403) {
                        this.$router.push({ path: '/profile' });
                    }
                });
        }
    }
}
</script>
