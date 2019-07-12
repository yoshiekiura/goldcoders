import Vue from 'vue';

// Vue.mixin({ methods: { route: (...args) => window.route(...args).url() } })
Vue.mixin({
    methods: {
        route: route
    }
});