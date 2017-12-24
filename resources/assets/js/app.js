
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//require('vue2-autocomplete-js');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('search', require('./components/autocomplete.vue'));
Vue.component('phone', require('./components/phone.vue'));
const app = new Vue({
    el: '#app',
    data: {
        value : {
            name : '',
            full_name : '',
            address: '',
            inn: '',
            opf: '',
            opf_id: '',
            web: '',
            email: '',
            description: '',
        },
    },

    created: function () {
        if ( typeof data !== "undefined" ) {
            this.value = Object.assign(this.value, data);
            console.log(data);
            console.log(this.value);
        }
    },
    methods: {
        setValue: function ( param ) {
            this.$set( this.value , param.name, param.id)
        },

        getCompany: function ( param ) {
            axios.get('/ajax/get/company', {
                params: {
                    id: param.id
                }
            })
              .then( this.company )
              .catch(function (error) {
                    console.log(error);
                });
        },

        company: function ( company ) {
            this.value.name = company.data.name;
            this.value.full_name = company.data.full_name;
            this.value.inn = company.data.inn;
            this.value.address = company.data.postal +
                ', ' + company.data.region +
                ', ' + company.data.locality +
                ', ' + company.data.street;
            this.$refs.search.$refs.autocomplete.setValue(this.value.address);
        }
    }
});
