Nova.booting((Vue, router) => {
    Vue.component('nova-button', require('./components/NovaButton'));
    Vue.component('index-nova-button', require('./components/IndexField'));
    Vue.component('detail-nova-button', require('./components/DetailField'));
    Vue.component('form-nova-button', require('./components/FormField'));
})
