import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import 'roboto-fontface/css/roboto/roboto-fontface.css'
import 'vuetify/dist/vuetify.min.css'

//? https://vuetifyjs.com/en/framework/icons#using-custom-icons

import 'material-design-icons-iconfont/dist/material-design-icons.css'     //! iconfont: 'md'
//import '@mdi/font/css/materialdesignicons.css'                          //! iconfont: 'mdi'
import '@fortawesome/fontawesome-free/css/all.css'                      //! iconfont: 'fa'
//import 'font-awesome/css/font-awesome.min.css'                          //! iconfont: 'fa4'

Vue.use(Vuetify,{
    icons: {
        iconfont: 'fa'
    },
    theme: {
        primary: '#BA9A5a',
        secondary: '#1F2833',
        accent: '#103050',
        error: '#800020',
        info: '#7fcac3',
        success: '#00695c',
        warning: '#f9a825'
    },
    options: {
        customProperties: true
    }
})



