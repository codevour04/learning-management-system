import '@mdi/font/css/materialdesignicons.css'
import 'sweetalert2/dist/sweetalert2.min.css'
import 'vue3-easy-data-table/dist/style.css'
import 'vuetify/styles'
import { aliases, mdi } from 'vuetify/iconsets/mdi'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import App from './App.vue'
import Axios from 'axios'
import router from './router'
import store from './store'
import Vue3EasyDataTable from 'vue3-easy-data-table'
import VueApexCharts from "vue3-apexcharts";
import VueSweetalert2 from 'vue-sweetalert2'

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    }
  },
})

const app = createApp(App);

app.use(createPinia())
  .use(store)
  .use(vuetify)
  .use(router)
  .use(VueSweetalert2)
  .use(VueApexCharts)
  .component('EasyDataTable', Vue3EasyDataTable);

app.config.globalProperties.$http = Axios;
app.mount('#app')
