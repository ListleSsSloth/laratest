<template>
    <div class="form-group">
        
        <table style="vertical-align: middle">
            <tr>
                <td>
                    <select multiple v-model="selected_1" class="form-control selectlist" style="height: 300px">
                        <option v-for="item in dataBox_1">
                            {{ item }}
                        </option>
                    </select>
                </td>
                <td>
                    &nbsp;<button @click.prevent="changeItems('add')" class="btn btn-outline-secondary btn-sm">>>></button>
                    

                    &nbsp;<button @click.prevent="changeItems('remove')" class="btn btn-outline-secondary btn-sm"><<<</button>
                </td>
                <td>
                    <select multiple v-model="selected_2" class="form-control selectlist" style="height: 300px">
                        <option v-for="item in dataBox_2">
                            {{ item }}
                        </option>
                    </select>
                </td>
            </tr>
        </table>
        



        <form :action="post_url" method="post" @submit="checkAndSubmitForm">
            <div v-if="form_errors.length" class="alert alert-danger">
                <b>Ошибка:</b>
                <ul>
                    <li v-for="error in form_errors">{{ error }}</li>
                </ul>
            </div>
            <p>
                <input type="submit" value="Отправить" class="btn btn-primary">
            </p>
            <input type="hidden" :value="csrfToken" name="_token"/>
            <input type="hidden" name="dataField" id="dataField">
        </form>


        <div>
            <div v-if="response_data['error-code'] == 0" class="alert alert-success">
                {{response_data['message']}}
            </div>


            <div v-if="response_data['error-code'] > 0" class="alert alert-danger">
                {{response_data['message']}}
                <div v-if="response_data['errors'].length">
                    <b>Ошибка:</b>
                    <ul>
                        <li v-for="error in response_data['errors']">{{error}}</li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
</template>


<script>
    export default {
        props: {
            vuedata: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                //form data
                csrfToken: null,
                form_errors: [],
                xField: null,


                //local data
                post_url: this.vuedata['post-url'], 
                response_data: this.vuedata['response-data'], //состояния успеха возвращенные с сервера
                dataBox_1: this.vuedata['list-data'], //список - источник данных
                dataBox_2: [],
                selected_1: [],
                selected_2: [],
            }
        },
        mounted() {
            console.log('Vue Component \"' + this.$options.name + '\" mounted...')
        },
        created() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        methods: {
            checkAndSubmitForm: function (e) {
                this.form_errors = [];


                if (this.dataBox_2.length <= 0) {
                    this.form_errors.push('Требуется выбрать хотябы один элемент');
                }


                if (!this.form_errors.length) {
                    document.getElementById('dataField').value = JSON.stringify(this.dataBox_2);
                    return true;
                }
                e.preventDefault();
            },
            changeItems: function (mode) {
                const vueSel1 = this.selected_1;
                const vueSel2 = this.selected_2;
                const vueDb1 = this.dataBox_1;
                const vueDb2 = this.dataBox_2;


                if (mode == 'add' || mode == 'remove') {
                    if (mode == 'add') {
                        vueSel1.forEach(function (item) {
                            vueDb2.push(item);
                            vueDb1.splice(vueDb1.indexOf(item), 1);
                        });
                        this.selected_1 = [];
                    }
                    if (mode == 'remove') {
                        vueSel2.forEach(function (item) {
                            vueDb1.push(item);
                            vueDb2.splice(vueDb2.indexOf(item), 1);
                        });
                        this.selected_2 = [];
                    }
                    return;
                } else {
                    throw new Error("Неверный режим функции(add or remove)");
                }
            },
        }
    }
</script>


<style>
    .selectlist {
        width: 420px;
        resize: none;
    }
</style>