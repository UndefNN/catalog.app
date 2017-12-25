
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
            phone: '',
            web: '',
            email: '',
            description: '',
        },
        pattern: {
            email: /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/,
            phone: /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/,
            inn: /(^\d{10}\b)|(^\d{12}$)/,
            web: /^([a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$/,

        }
    },

    created: function () {
        if ( typeof data !== "undefined" ) {
            this.value = Object.assign(this.value, data);
            console.log(data);
            console.log(this.value);
        }
    },

    computed: {
        isNameValid: function() {
            return {
                'has-success': this.value.name.length > 3,
                'has-error': this.value.name.length <= 3 && this.value.name.length > 0,
            }
        },

        isFullNameValid: function() {
            return {
                'has-success': this.value.full_name.length > 3,
                'has-error': this.value.full_name.length <= 3 && this.value.full_name.length > 0,
            }
        },

        isAddressValid: function() {
            return {
                'has-success': this.value.address.length > 0,
            }
        },

        isOpfValid: function() {
            return {
                'has-success': this.value.opf_id > 0,
            }
        },

        isPhoneValid: function() {
            return {
                'has-success': this.pattern.phone.test(this.value.phone),
                'has-error': this.pattern.phone.test(this.value.phone) && this.value.phone !== '',
            }
        },

        isEmailValid: function() {
            return {
                'has-success': this.pattern.email.test(this.value.email),
                'has-error': !this.pattern.email.test(this.value.email) && this.value.phone !== '',
            }
        },

        isInnValid: function () {
            return {
                'has-success': this.pattern.inn.test(this.value.inn),
                'has-error': !this.pattern.inn.test(this.value.inn) && this.value.inn !== '',
            }
        },

        isWebValid: function () {
            return {
                'has-success': this.pattern.web.test(this.value.web),
                'has-error': !this.pattern.web.test(this.value.web) && this.value.web !== '',
            }
        },

        isFormValid() {
            return  !this.isNameValid['has-error'] &&
                    !this.isFullNameValid['has-error']  &&
                    !this.isAddressValid['has-error'] &&
                    !this.isPhoneValid['has-error'] &&
                    !this.isEmailValid['has-error'] &&
                    !this.isInnValid['has-error'] &&
                    !this.isWebValid['has-error']
        },

    },

    methods: {
        setValue: function ( param ) {
            this.$set( this.value , param.name, param.value)
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
            this.$set( this.value, 'name', company.data.name);
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
