<template>
    <div>

        <body class="body">
        <div class="section-lk">
            <div class="col-lk w-row">
                <div class="column-10 w-col w-col-2 w-col-medium-2">
                    <div class="div-block-29">
                        <a href="/" class="w-nav-brand">
                            <h1 class="logo-lk">Юран</h1>
                        </a>
                        <a href="#" class="link-block-2 w-inline-block">
                        </a>


                    </div>

                    <div class="div-block-28">
                        <router-link  :to="{ name: 'expertise_juran' }">
                        <a href="" class="link-menu lk w-inline-block ">
                                <div>Экспертиза сделки</div>
                        </a>
                        </router-link>
                        <nav class="slow_nav">
                            <ul>
                                <li>
                                    <a href="#" class="link-menu lk sub w-inline-block">Субъекты</a>
                                    <ul>
                                        <li>
                                            <router-link  :to="{ name: 'subjects_list' }"><a href="#" class="link-menu  setting w-inline-block">Список субъектов</a>
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link  :to="{ name: 'prep_doc' }"><a href="#" class="link-menu  setting w-inline-block">Добавить субъект</a>
                                            </router-link>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                        <nav class="slow_nav">
                            <ul>
                                <li>
                                    <a href="#" class="link-menu lk sub w-inline-block">Документы</a>
                                    <ul>
                                        <li>
                                            <router-link  :to="{ name: 'doc' }"><a href="#" class="link-menu  setting w-inline-block">Подготовить документы</a>
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link  :to="{ name: 'my_doc' }"><a href="#" class="link-menu  setting w-inline-block">Мои документы</a>
                                            </router-link>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                        <a href="#" class="link-menu lk graf w-inline-block">
                            <div>Графические схемы</div>
                        </a>
                        <a href="#" class="link-menu lk post w-inline-block">
                            <div>Постановления<br/>и законы</div>
                        </a>
                        <router-link  :to="{ name: 'settings' }">
                        <a href="#" class="link-menu lk setting w-inline-block">
                            <div>Настройки</div>
                        </a>
                        </router-link>

                        <a href="#" class="link-menu lk help w-inline-block">
                            <div>Поддержка</div>
                        </a>

                        <a href="#" class="link-menu lk help w-inline-block" v-on:click="exit_from_acc">
                            <div>Выйти</div>
                        </a>

                        <a href="#" class="link-menu lk setting w-inline-block" v-if="is_admin=='1'" v-on:click="goto_admin">
                            <div>Панель администратора</div>
                        </a>


                    </div>
                </div>
                <div class="column-9 w-col w-col-10 w-col-medium-10">
                    <div class="div-block-27">
                        <div class="form-block w-form">
                            <form id="email-form" name="email-form" data-name="Email Form">
                                <input type="text" class="text-field-2 w-input" maxlength="256" data-name="Поиск" placeholder="Поиск" id="node-2"/>
                            </form>
                            <div class="w-form-done">
                                <div>Thank you! Your submission has been received!</div>
                            </div>
                            <div class="w-form-fail">
                                <div>Oops! Something went wrong while submitting the form.</div>
                            </div>
                        </div>
                        <a class="link-block-3 w-inline-block">
                        <div class="text-block-15" v-if="user_info_var!=''">{{this.user_info_var.data.name}} {{this.user_info_var.data.surname}}</div>
                        <div class="div-block-30 image-upload">
                            <label for="customFile" class="my_pointer">
                                <img :src="image_src">
                            </label>
                            <input type="file"
                                   class="custom-file-input"
                                   id="customFile"
                                   @change="onAttachmentChange"
                            >
                        </div>
                         </a>
                    </div>
<!--                                            <button type="button" class="btn btn-primary btn-block procedure_button" v-on:click="test" >test</button>-->

                    <router-view></router-view>

                    <modal_error v-if="showModal" @close_error="close_modal" :message='mes_err' >
                        <h3 slot="link">Выберите блок</h3>
                    </modal_error>

                </div>
            </div>
        </div>
</body>


    </div>
</template>

<script>

    export default {

        data(){

            return {
                is_admin:'0',
                user_info_var:'',
                // image_src: '/avatars/2',
                image_src: '',
                name: 'my_pic',
                attachment: null,
                showModal:false,
                mes_err:''
            }
        },
        mounted() {
          this.is_admin_add();
          this.user_info();
        },
        methods: {



            close_modal(data)
            {
                this.showModal = false;

            },

            submit () {

                const config = { 'content-type': 'multipart/form-data' };
                const formData = new FormData();
                // formData.append('name', this.name)
                formData.append('attachment', this.attachment);
                axios.post('/store_pic', formData, config)

                    // )
                    .then(response => {

if(response.data.status=='success')
{
    this.image_src='/avatars/'+this.user_info_var.data.id+'_'+response.data.data,
        axios
            .post('/del_ava',{
                img_path:'avatars/'+this.user_info_var.data.id+'_'+response.data.data,
            });

}
else
    (
        this.mes_err=response.data.mes.image,
            this.mes_err=this.mes_err[0],
        this.showModal=true
)

                    })

            },

            del_img()
            {
                axios.post('/del_ava')
            },

            onAttachmentChange (e) {
                this.attachment = e.target.files[0];
                this.submit();
            },

            test()
            {
                axios
                    .post('/save_word_doc')
            },

            goto_admin()
            {
                Vue.router.push({name:'admin'});
            },

            user_info(inp)
            {
                axios
                    .get('/auth/user',{
                    }).then(({ data }) => (
                         this.user_info_var=data,

                             axios
                                 .post('/check_ava',{
                                 }).then(response => {
                                    if(response.data=='1')
                                    {
                                        this.image_src='/avatars/'+this.user_info_var.data.id

                                    }
                                    else
                                    {
                                        this.image_src='/avatars/0'
                                    }
                             })


                    )

                );

            },


            is_admin_add()
            {
                axios.get('/is_admin').then(({ data }) => (
                        this.is_admin=data,
                this.$store.dispatch('setIsAdmin', data)

                    )
                )
            },

            exit_from_acc()
            {
                axios.post('/auth/logout').then(({ data }) => (
                    window.location.href = "http://mart.juran.by"
                    // window.location.href = "http://localhost"
                    )

                )

            }




        },

    }
</script>


