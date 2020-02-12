<template>
    <div class="col">
        <div class="div-block-8">
            <h1 class="heading">Категории экспертиз</h1>

            <div v-if="!show_textarea" class="div-block-add-cat-exp">
                <div class="w-form">
                    <h2 class="heading-4">Создать новую категорию экспертиз</h2>
                    <form v-on:submit.prevent="push_the_button" id="email-form-2" name="email-form-2" data-name="Email Form 2" class="form-4">
                        <div class="div-block-51"><div>
                            <label for="node-2" class="field-label-exp">Название</label>
                            <textarea v-model="nazwanie"  placeholder="Введите название категории" maxlength="5000"  data-name="Название категории" class="text-field-new w-input"></textarea>
                        </div>
                            <div>
                                <label for="node-4" class="field-label-exp">Подзаголовок</label>
                                <textarea v-model="new_post_message" placeholder="Введите подзаголовок категории" maxlength="5000"  data-name="Подзаголовок категории" class="text-field-new w-input"></textarea>
                            </div>
                        </div>
                        <input  type="submit" value="Создать" data-wait="Ожидайте..." class="button-3 create w-button"/>
                    </form>
                </div>
            </div>


            <div v-if="show_textarea" class="div-block-add-cat-exp">
                <div class="w-form">
                    <h2 class="heading-4">Редактировать текущую экспертизу</h2>
                    <form v-on:submit.prevent="save_change_post_name" class="form-4">
                        <div class="div-block-51"><div>
                            <label for="node-2" class="field-label-exp">Название</label>
                            <textarea v-model="change_nazwanie"  placeholder="Введите название категории" maxlength="5000" id="node-2" data-name="Название категории" class="text-field-new w-input"></textarea>
                        </div>
                            <div>
                                <label for="node-4" class="field-label-exp">Подзаголовок</label>
                                <textarea v-model="text_area_message" v-bind:class="{border_alert: danger_ans}" placeholder="Введите подзаголовок категории" maxlength="5000" id="node-4" data-name="Подзаголовок категории" class="text-field-new w-input"></textarea>
                            </div>
                        </div>
                        <input  type="submit" value="Сохранить" data-wait="Ожидайте..." class="button-3 create w-button"/>
                    </form>
                </div>
            </div>

            <div class="div-block-adm-name">
                <div class="w-row">
                    <div class="w-col w-col-4 w-col-small-3 w-col-tiny-3">
                        <div class="text-block-name">Название</div>
                    </div>
                    <div class="w-col w-col-4 w-col-small-3 w-col-tiny-3">
                        <div class="text-block-name _2">Подзаголовок </div>
                    </div>
                    <div class="w-col w-col-2 w-col-small-3 w-col-tiny-3">
                        <div class="text-block-name avt _1">Активна</div>
                    </div>
                    <div class="w-col w-col-2 w-col-small-3 w-col-tiny-3">
                        <div class="text-block-name avt">Автор</div>
                    </div>
                </div>
            </div>
            <div  v-for="(post, number) in posts" class="div-block-adm-body">
                <div class="columns-6 w-row">
                    <div class="column-12 w-col w-col-4 w-col-small-small-stack">
                        <div class="text-block-name-body like_a_link_hover"  v-on:click="edit_post(post.id_post,post.nazwanie)">{{ post.nazwanie }}</div>
                    </div>
                    <div class="w-col w-col-4 w-col-small-small-stack">
                        <div class="text-block-name-body _2 like_a_link_hover"  v-on:click="edit_post(post.id_post,post.nazwanie)">{{ post.text }}</div>
                    </div>
                    <div class="column-centr-active avt _1 w-col w-col-2 w-col-small-small-stack">
                        <div class="form-block-2 w-form">
<!--                            <form id="email-form" name="email-form" data-name="Email Form" class="form-3">-->
                                <label class="w-checkbox checkbox-field">
                                    <input  :checked="post.id_post == current_front_post" v-on:click="change_front_current_post(post.id_post,post.text)" type="radio"  name="checkbox"  class="w-checkbox-input checkbox my_pointer">
                                    <span class="checkbox-label w-form-label my_pointer"></span>
                                </label>
                            </form>
                        </div>
                        <div class="div-pendel my_pointer" v-on:click="change_post_name(post.id_post,post.text,post.nazwanie)"></div>
                        <div class="div-del my_pointer" v-on:click="delete_post(post.id_post,number)"></div>
                    </div>
                    <div class="column-centr w-col w-col-2 w-col-small-small-stack">
                        <div class="text-block-name-body avt">{{post.author}}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>

    export default {

        data(){

            return {
                //главный массив постов
                posts: [],
                //массив в который положится промежуточное значение постов
                removed:[],
                //текущий номер страницы пагинации
                pagination_numb:0,
                //количество постов всего ( для пагинации )
                posts_length:0,
                current_front_post :0,
                show_textarea:false,
                text_area_message:'',
                change_name_id_post:'',
                danger_ans:false,
                new_post_message:'',
                nazwanie:'',
                change_nazwanie:''
            }
        },
        mounted() {
            this.render_table(this.posts, this.removed, this.pagination_numb, this.posts_length);
            this.select_front_current_post();
            this.find_post_id();
            this.user_info();
        },
        methods: {

            user_info()
            {
                axios
                    .get('/auth/user',{
                    }).then(({ data }) => (
                        this.user_info_var=data
                    )
                );
            },


            push_the_button()
            {
                this.danger_ans = false;
                this.new_post_message = this.new_post_message.trim();
                this.nazwanie = this.nazwanie.trim();
                if(this.new_post_message==''|| this.nazwanie=='')
                {
                    this.danger_ans = true;
                }
                else
                {
                    //установим имя поста
                    this.$store.dispatch('changeName', this.new_post_message),
                        //сохраним пустую процедуру
                        axios
                            .post('/add_procedure',{
                                id_post:this.$store.state.post_id,
                                name_post:this.$store.state.namePost,
                                nazwanie:this.nazwanie,
                                author:this.user_info_var.data.name + ' ' + this.user_info_var.data.surname,
                                id_main_procedure:0,
                                name_main_procedure:0
                            }).then( Vue.router.push({name:'add_procedures',params : {nazwanie_proc: this.nazwanie}}));
                }
            },


            find_post_id()
            {
                axios
                    .post('/post_id').then(({ data }) => (
                        //установим номер поста
                        this.$store.dispatch('setPostCounter', data+1)
                    )
                )
            },

            save_change_post_name()
            {

                this.danger_ans = false;
                if(this.text_area_message==''||this.text_area_message==' ')
                {
                    this.danger_ans = true;
                }
                else
                {
                for (let i = 0; i < this.posts.length; i++) {
                    if(this.posts[i]['id_post']==this.change_name_id_post)
                    {
                        this.posts[i]['text']=this.text_area_message;
                        this.posts[i]['nazwanie']=this.change_nazwanie;
                        this.show_textarea = false;
                        axios
                            .post('/update_post_name',{
                                id_post:this.change_name_id_post,
                                name_post:this.text_area_message,
                                nazwanie:this.change_nazwanie
                            });
                    }
                }
                }



            // this.posts[this.change_name_id_post]['text']=this.text_area_message
            },
            change_post_name(post_id, post_text,nazw) {
            this.show_textarea = true;
            this.text_area_message = post_text;
            this.change_name_id_post=post_id;
            this.change_nazwanie=nazw;
            },

            render_table(inp, removed, pagination_numb)
            {
                //множитель количества постов на странице ( он же номер )
                pagination_numb=pagination_numb*10;
                axios
                    .post('/render_posts',{
                    }).then(({ data }) => (
                    //запишем количество постов
                        this.posts_length=data.length,
                        //пагинация с какой позиции и сколько взять
                            removed= data.splice(pagination_numb, 10),
                                removed.forEach(function(entry) {
                                inp.push({
                                    text:entry.name_post,
                                    id_post:entry.id_post,
                                    nazwanie:entry.nazwanie,
                                    author:entry.author
                                });
                        })

                    )

                );
            },

            select_name(numb)
            {
                axios
                    .post('/select_name',{
                        id_post:numb,
                    })
                    .then(({ data }) => (
                       this.$store.dispatch('changeName', data.name_post)
                        )
                    );
            },

            change_front_current_post(id_post, name_post)
            {
                axios
                    .post('/add_current_post',{
                        id_post:id_post,
                        name_post:name_post
                    });
            },

            select_front_current_post()
            {
                axios
                    .post('/select_front_current_post',{
                    })
                    .then(({ data }) => (
                        this.current_front_post=data
                        )
                    );
            },

            edit_post(numb, nazw)
            {

                this.nazwanie = nazw;
                if(this.nazwanie=='')
                {
                    alert('отредактируйте название');
                }
                else
                {

                //выбираю номер линии у поста
               this.select_name(numb);
                //меняю значение поста
                this.$store.dispatch('setPostCounter', numb);
                //имя поста
                Vue.router.push({name:'add_procedures',params : {nazwanie_proc: nazw}});
                }
            },
            delete_post(numb, numb_in_arr)
            {
                axios
                    .post('/delete_post',{
                        id_post:numb,
                    });
                this.posts.splice(numb_in_arr,1)
            },
            next()
            {
                if(((this.pagination_numb+1) * 10)<(this.posts_length))
                {
                    this.posts=[];
                    this.pagination_numb++;
                    this.render_table(this.posts, this.removed, this.pagination_numb);
                }

            },
            prev()
            {
                if(this.pagination_numb != 0)
                {
                    this.posts=[];
                    this.pagination_numb--;
                    this.render_table(this.posts, this.removed, this.pagination_numb);
                }

            },

        },

    }
</script>
