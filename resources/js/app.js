import Inertia from 'inertia-vue'
import Vue from 'vue'
import '@/plugins'

Vue.use(Inertia)

Vue.config.productionTip = false
const app = document.getElementById('app')

new Vue({
    render: h => h(Inertia, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
        },
    }),
}).$mount(app)