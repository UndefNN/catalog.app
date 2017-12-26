<template>
    <div id="phone-block">
            <div
                class="form-group"
                v-for="(phone, index) in phones"
                :key="index"
            >
                <label class="control-label">Номер телефона</label>
                <div class="input-group">
                <input
                        type="text"
                        placeholder="Введите номер телефона"
                        class="form-control"
                        :name="'phone['+ index +'][number]'"
                        v-model="phones[index].number"
                >

                <div class="input-group-btn">
                    <button type="button" class="btn btn-flat bg-olive " @click="addPhone">+</button>
                    <button type="button" class="btn btn-flat bg-maroon" @click.prevent="removePhone(index)" :disabled="quantity">-</button>
                </div>
                </div>

            </div>
    </div>
</template>

<script>
    export default {
        props: ['phone'],
        data:
            function () {
                return {
                    phones:
                        [{
                            type: '',
                            number: ''
                        }],
                }
            },

        computed: {
            quantity: function() {
                return this.phones.length === 1;
            },
        },

        methods: {

            addPhone: function (event) {
                event.preventDefault();
                this.phones.push({
                    type: '',
                    number: '',
                });

                this.$nextTick(function () {
                    console.log(this.$el.id);
                }.bind(this));
            },
            removePhone: function (index) {
                if (this.phones.length > 1)
                    this.phones.splice(index, 1);
            }
        }

    }
</script>