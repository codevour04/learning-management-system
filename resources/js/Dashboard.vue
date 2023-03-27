<template>
    <v-app id="inspire">
        <app-bar />
        <side-drawer ref="navDrawer">
            <router-link to="/user" v-if="canViewUserManagement"> User management </router-link>
        </side-drawer>
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row>
                    <v-col style="text-align: center">
                        <h2>
                            Year 2022 monthly sales performance (%)
                        </h2>
                    </v-col>
                </v-row>
                <v-row>
                    <!-- <v-col>
                         <apexchart
                            width="500"
                            type="bar"
                            :options="chartOptions"
                            :series="series"
                        />
                    </v-col> -->
                    <v-col v-if="hasSales">
                        <div class="d-flex justify-center">
                            <apexchart type="pie" width="700" :options="pieOptions" :series="monthlySales" />
                        </div>
                    </v-col>
                    <v-col v-else>
                        <div class="d-flex justify-center">
                            <h4>No data to display</h4>
                        </div>
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

const MONTHS = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
];

export default {
    name: 'Dashboard',

    components: {
        AppBar,
        SideDrawer
    },

    data () {
        return {
            // chartOptions: {
            //     chart: {
            //         id: "vuechart-example",
            //     },
            //     xaxis: {
            //         categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998],
            //     },
            // },
            pieOptions: {
                chart: {
                    width: 700,
                    type: 'pie',
                },
                labels: MONTHS,
                responsive: [{
                    breakpoint: 700,
                    options: {
                        chart: {
                            width: 700
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            },
            loggedInUserPermissions: null,
            // series: [
            //     {
            //         name: "series-1",
            //         data: [30, 40, 35, 50, 49, 60, 70, 91],
            //     },
            // ],
            monthlySales: [],
        }
    },

    mounted () {
        this.getAuthUserAndPermissions();
        this.fetchTransactions();
    },

    computed: {
        ...mapState({
            loggedUser: state => state.user
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
        },

        hasSales () {
            let sum = this.monthlySales.reduce(function (previous, current) {
                return previous + current;
            }, 0);

            return (sum > 0) ?? false;
        },

        canViewUserManagement () {
            return (this.loggedUser.permissions.length > 0);
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
                    this.$store.commit('setUser', response.data);
                    window.App.user = response.data;
                })
        },

        toggleDrawer () {
            this.$store.commit('setDrawToggle')
        },

        fetchTransactions () {
            this.$http.get("ajax/transactions")
                .then((response) => {
                    let sales = response.data;

                    MONTHS.forEach((month) => {
                        if (sales[month]) {
                            this.monthlySales.push(sales[month]);
                        } else {
                            this.monthlySales.push(0);
                        }
                    })
                });
        }
    }
}
</script>
