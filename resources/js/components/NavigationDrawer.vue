<template>
    <v-navigation-drawer class="bg-amber-darken-4" v-model="drawToggle">
        <div class="d-flex justify-center my-10" >
            <slot></slot>
        </div>
    </v-navigation-drawer>
</template>

<script>

import { mapState } from 'vuex'

export default {
    name: 'NavigationDrawer',

    data () {
        return {
        }
    },

    created() {
    },

    mounted () {
    },

    computed: {
        ...mapState({
            drawToggle: state => state.drawToggle
        }),
    },

    methods: {
    }
}
</script>
