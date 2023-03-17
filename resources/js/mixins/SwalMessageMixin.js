export default {
    name: 'SwalMessageMixin',

    methods: {
        swalMixinbasicMessage (config) {
            this.$swal.fire(config)
        },

        swalMixinSuccessMessage (message) {
            this.$swal.fire(message, '', 'success')
        }
    },
};
