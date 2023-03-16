export default {
    name: 'SwalMessageMixin',

    methods: {
        basicAlertMessage (config) {
            this.$swal.fire(config)
        },

        successAlertMessage (message) {
            this.$swal.fire(message, '', 'success')
        }
    },
};
