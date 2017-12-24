<template>
    <div>
        <!--
        <div class="container">
            -->
        <div class="row">

            <div

                    v-for="(phone, index) in phones"
            >

                <div class="col-sm-10">
                    <div class="input-group">
                        <input
                                type="text"
                                :name="'phone['+ index +'][number]'"

                                v-model="phone.number"
                                data-inputmask=" 'mask':['+7 (999) 999-99-99]', '+7 (34299) 9-99-99'"
                                data-mask="">

                    </div>
                </div>
                <input type="hidden" name="id" v-model="phone.id"/>

                <div class="col-sm-1">
                    <div class="input-group">
                        <button
                                type="button"
                                class="btn btn-group-lg"
                                @click="addphone">
                            +
                        </button>
                    </div>
                </div>
                <div class="col-sm-1 ">
                    <div class="input-group">
                        <button
                                type="button"
                                class="btn btn-group-lg"
                                @click="removephone(index)">
                            -
                        </button>
                    </div>
                </div>
            </div>


        </div>

        <!--
          </div>-->

    </div>


</template>
<script>
    export default {
        mounted() {
            if (company_id>0) {
                axios.get('/phone/' + this.company_id)
                    .then(response => {
                        this.phones = response.data;
                    })
                    .catch(function (error) {
                        if (error.response) {
                            // The request was made and the server responded with a status code
                            // that falls out of the range of 2xx
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                        }
                        console.log(error.config);
                    });
            }
        },

        props: ['company_id'],
        data:
            function () {
                return {
                    phones:
                        [{
                            type: '',
                            number: ''
                        }]
                }
            },

        methods: {

            addphone: function (event) {
                event.preventDefault()
                console.log(this.company_id);
                this.phones.push({
                    type: '',
                    number: '',
                    id: '',
                });

                this.$nextTick(function () {
                    console.log(this.$el.id);
                }.bind(this));
            },
            removephone: function (index) {
                if (this.phones.length > 1)
                    this.phones.splice(index, 1);
            }
        }

    }
</script>
<style scoped>
    .mb-5 {
        margin-bottom: 10px;
    }
</style>