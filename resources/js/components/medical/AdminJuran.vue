<template>
    <div >
        <body class="body">
        <div class="section-lk">
            <div class="col-lk w-row">
                <div class="column-10 w-col w-col-2">
                    <div class="div-block-29">
                        <a href="/" class="brand-2 w-nav-brand">
                            <h1 class="logo-lk">Юран</h1>
                        </a>
                        <a href="#" class="link-block-2 w-inline-block"></a>
                    </div>
                    <div class="div-block-28-adminpanel">
                        <router-link :to="{ name: 'posts' }"><a href="#" class="link-menu-adm">Экспертизы</a></router-link>
                        <router-link :to="{ name: 'users_list' }"><a href="#" class="link-menu-adm">Пользователи</a></router-link>
                        <router-link :to="{ name: 'profile_juran' }"><a href="#" class="link-menu-adm">На сайт</a></router-link>
                    </div>
                </div>
                <div class="column-9 w-col w-col-10">
                    <div class="div-block-27">
                        <div class="text-block-32">Панель администратора</div>
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
                    <div class="div-adminpanel">
                        <router-view ></router-view>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-2">
            <div class="div-block-7">
                <div class="columns w-row">
                    <div class="w-col w-col-6">
                        <div>
                            <div class="text-block">  © Все права защищены</div>
                        </div>
                    </div>
                    <div class="w-col w-col-6"></div>
                </div>
            </div>
        </div>
</body>
</div>

</template>


<script>

    export default {
        data () {
            return {
                user_info_var: '',
                image_src: ''

            }
        },
        mounted() {
            this.user_info();
        },
        methods: {

            user_info()
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

            onAttachmentChange (e) {
                this.attachment = e.target.files[0];
                this.submit();
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

        }
    }
</script>
