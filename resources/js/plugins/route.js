import Vue from 'vue';

Vue.mixin({ methods: { route: (...args) => window.route(...args).url() } })