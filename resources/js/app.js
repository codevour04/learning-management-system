import { createPinia } from 'pinia'
import '@mdi/font/css/materialdesignicons.css'
import 'sweetalert2/dist/sweetalert2.min.css'
import 'vuetify/styles'
import { aliases, mdi } from 'vuetify/iconsets/mdi'
import { createApp } from 'vue'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import App from './App.vue'
import Axios from 'axios'
import router from './router'
import store from './store'
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

const app = createApp(App).use(createPinia()).use(store).use(vuetify).use(router).use(VueSweetalert2);

app.config.globalProperties.$http = Axios;
app.mount('#app')
