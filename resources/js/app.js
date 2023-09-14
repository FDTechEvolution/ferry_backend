import './bootstrap';
import {createApp} from 'vue'

import App from './App.vue'
import router from './router/index.js'
import layout_header from './layouts/header.vue'
import layout_sidebar from './layouts/sidebar.vue'
import layout_pagetitle from './layouts/page_title.vue'
import layout_footer from './layouts/footer.vue'

const app = createApp(App)
app.use(router)
app.component('layout-header', layout_header)
app.component('layout-sidebar', layout_sidebar)
app.component('layout-pagetitle', layout_pagetitle)
app.component('layout-footer', layout_footer)
app.mount('#app')