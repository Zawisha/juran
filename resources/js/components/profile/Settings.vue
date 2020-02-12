<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 settings_div">
                <h2>
                    Поменять данные
                </h2>
    <div >Имя</div>
    <div class="settings_inp">
        <input class="col-4" v-model="user_name" type="text" placeholder="Имя" v-bind:class="{border_alert: elemInArr(1)}">
    </div>
    <div >Фамилия</div>
    <div class="settings_inp">
        <input class="col-4" v-model="user_surname" type="text" placeholder="Фамилия" v-bind:class="{border_alert: elemInArr(2)}">
    </div>
    <div>Телефон</div>
    <div class="settings_inp">
        <input class="col-4" v-model="user_telefon_number" type="text" placeholder="Номер телефона" v-bind:class="{border_alert: elemInArr(3)}">
    </div >
    <button type="button" class="btn btn-info col-4 save_settings" v-on:click="save_data">Сохранить</button>

                <div class="alert alert-success col-4 note_alert" role="alert" v-if=(show_div_n(4))>
                    Изменения сохранены
                </div>
                <div class="alert alert-danger col-4 note_alert" role="alert" v-if=(show_div_n(5)) v-for="(item, number) in alert_pass_mess_user">
                    {{ item }}
                </div>



    <h2>
        Поменять пароль
    </h2>

    <div>Старый пароль</div>
    <div class="settings_inp">
        <input class="col-4" v-model="old_pass" type="password" placeholder="Старый пароль" v-bind:class="{border_alert: elemInArr(4)}">
    </div>
    <div>Новый пароль</div>
    <div class="settings_inp">
        <input class="col-4" v-model="new_pass" type="password" placeholder="Новый пароль" v-bind:class="{border_alert: elemInArr(5)}">
    </div>
    <div >Повторите новый пароль</div>
    <div class="settings_inp">
        <input class="col-4" v-model="new_pass1" type="password" placeholder="Повторите пароль" v-bind:class="{border_alert: elemInArr(6)}">
    </div>
    <div class="alert alert-danger col-4 note_alert" role="alert" v-if=(show_div_n(3))>
       Пароли не совпадают
    </div>
    <button type="button" class="btn btn-secondary col-4 save_settings" v-on:click="save_pass" >Сохранить пароль</button>
    <div class="alert alert-success col-4 note_alert" role="alert" v-if=(show_div_n(1))>
        Пароль успешно изменён
    </div>
    <div class="alert alert-danger col-4 note_alert" role="alert" v-if=(show_div_n(2))>
{{ alert_pass_mess }}
    </div>

            </div>
       </div>
</div>
</template>

<script>

    export default {
        data () {
            return {
                user_name:'',
                user_surname:'',
                user_telefon_number:'',
                alarm_arr:[],
                old_pass:'',
                new_pass:'',
                new_pass1:'',
                alert_pass_mess:'',
                show_notice_arr:[],
                alert_pass_mess_user:[]
            }
        },
        mounted() {
            this.render_user_info();
        },
        methods: {

            show_div_n(numb)
            {
                return this.show_notice_arr.indexOf(numb) === -1 ? false : true

            },

            save_pass()
            {
                this.alert_pass_mess = '';
                this.show_notice_arr = [];
                this.alarm_arr=[];

                if(this.new_pass != this.new_pass1)
                {
                    this.check(this.new_pass, 5);
                    this.check(this.new_pass1, 6);
                    this.show_notice_arr.push(3);

                }

                else
                {
                    if(this.old_pass == '' || this.new_pass=='')
                    {
                        this.check(this.old_pass, 4);
                        this.check(this.new_pass, 5);
                    }
                    else
                    {
                        axios
                            .post('/change_password',{
                                old_pass:this.old_pass,
                                new_pass:this.new_pass,
                            })

                            .then(response => {

                                if(response.data.status == 'failed')
                                {
                                    if(response.data.valid == 'yes')
                                    {
                                        this.alert_pass_mess = response.data.message.new_pass[0];
                                        this.show_notice_arr.push(2);
                                    }
                                    else
                                    {
                                        this.alert_pass_mess = response.data.message;
                                        this.show_notice_arr.push(2);
                                    }

                                }
                                else
                                {
                                    this.show_notice_arr.push(1);
                                }

                            })
                    }

                }


            },

            check(inp,numb)
            {
                if(inp =='')
                {
                    this.alarm = true;
                    this.alarm_arr.push(numb);
                }

            },
            elemInArr(numb)
            {
                return this.alarm_arr.indexOf(numb) === -1 ? false : true
            },

            save_data()
            {
                this.alarm_arr=[];
                this.alert_pass_mess_user=[];
                this.show_notice_arr=[];

                    this.user_name = this.user_name.trim();
                    this.user_surname = this.user_surname.trim();
                    this.user_telefon_number = this.user_telefon_number.trim();

                    if(this.user_name==''|| this.user_surname==''||this.user_telefon_number=='' )
                    {

                        this.check(this.user_name, 1);
                        this.check(this.user_surname, 2);
                        this.check(this.user_telefon_number, 3);
                    }
                    else
                    {
                            axios
                                .post('/save_user_data',{
                                    user_name:this.user_name,
                                    user_surname:this.user_surname,
                                    user_telefon_number:this.user_telefon_number
                                })
                                .then(response => {

                                    if(response.data.status == 'failed')
                                    {
                                       let resp_obj =  response.data.message;
                                        for (let key in resp_obj) {

                                            this.alert_pass_mess_user.push(resp_obj[key][0])

                                        }
                                            // this.alert_pass_mess_user = response.data.message;
                                            this.show_notice_arr.push(5);
                                            console.log(this.alert_pass_mess_user);


                                    }
                                    else
                                    {
                                        this.show_notice_arr.push(4);
                                    }

                                })
                    }
            },

            render_user_info()
            {
                axios
                    .get('/auth/user',{
                    }).then(({ data }) => (
                        this.user_name=data.data.name,
                        this.user_surname=data.data.surname,
                        this.user_telefon_number=data.data.telefon
                    )
                );
            }

        }
    }
</script>
