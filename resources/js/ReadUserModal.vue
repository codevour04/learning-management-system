<template>
    <v-dialog v-model="showModal" width="auto">
        <div class="d-flex justify-center align-center" style="height: 50vh">
            <v-card min-width="400">
                <v-img
                    src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                    height="200px"
                    cover
                />
                <v-card-title>
                    Name: {{ user.name }}
                </v-card-title>
                <v-card-title>
                    Email: {{ user.email }}
                </v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="red"
                        rounded="pill"
                        icon="mdi-close"
                        @click="showModal = !showModal"
                    >
                    </v-btn>
                </v-card-actions>
            </v-card>
        </div>
    </v-dialog>
</template>

<script>

  export default {
    name: 'ReadUserModal',

    components: {
    },

    data: () =>
        ({
            user: null,
            showModal: false,
        }),

    methods: {
        showDialog (data) {
            this.showModal = true;
            this.user = data;
        },
    }
  }
</script>
