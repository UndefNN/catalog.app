<template>
    <autocomplete

            anchor       = "name"
            label        = "description"
            ref          = "autocomplete"
            :initValue   = "value"
            :url         = "url"
            :name        = "name"
            :placeholder = "placeholder"
            :min         = "4"
            :debounce    = "300"
            :classes="{
                wrapper: 'form-wrapper',
                input: 'form-control',
                list: 'list-group',
                item: 'list-group-item' }"
            :onSelect = myAction
            :onShouldRenderChild = myRender
    >
    </autocomplete>
</template>

<script>

    import Autocomplete from 'vue2-autocomplete-js';

    export default {

        props: ['url', 'onSelect', 'placeholder', 'name', 'target', 'render', 'value'],

        components: {Autocomplete},

        methods: {
            myAction(value) {
                switch (this.onSelect) {
                    case 'openLink':
                        location.href = value.link;
                        break;
                    case 'select':
                        this.$emit('update-value', {
                            'name': this.target,
                            'value': value.id,
                        });
                        break;
                    case 'update_address':
                        this.$emit('update-value', {
                            'name':  this.target,
                            'value': value.unrestricted,
                        });
                        break;
                    case 'getCompany':
                        this.$emit('get-company', {
                            'id': value.id
                        });
                        break;
                }
            },

            myRender(value) {
                let html;
                let pattern;
                let query;

                query = value.query.split(/[^а-яa-z]+/gi).join("\|");
                pattern = new RegExp('('+ query +')', 'gui');

                switch (this.render) {
                    case 'address':
                        html = `<span class="autocomplete-anchor-text">${ value.name.replace( pattern, '<b>$1</b>' ) }</span>`;
                        break;
                    default:
                        html = `<span class="autocomplete-anchor-text">${ value.name.replace( pattern, '<b>$1</b>' ) }</span>`;
                        if ( value.description !== "" ) {
                            html += `<span class="autocomplete-anchor-label">${ value.description.replace( pattern, '<b>$1</b>' ) }</span>`
                        }
                        break;
                }

                return html;
            },
        }
    }

</script>