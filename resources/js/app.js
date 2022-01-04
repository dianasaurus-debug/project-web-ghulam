import Vue from 'vue'
import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { InertiaProgress } from '@inertiajs/progress'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import Multiselect from 'vue-multiselect'
import moment from 'moment'
moment.locale('id');


Vue.config.productionTip = false
Vue.mixin({ methods: { route: window.route } })
Vue.use(PortalVue)
Vue.use(VueMeta)
Vue.component('Multiselect', Multiselect)
Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('Do MMMM YYYY HH:mm')
    }
})
InertiaProgress.init()

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, app, props }) {
    new Vue({
      metaInfo: {
        titleTemplate: title => (title ? `${title} - Ping CRM` : 'Ping CRM'),
      },
      render: h => h(app, props),
    }).$mount(el)
  },
})
