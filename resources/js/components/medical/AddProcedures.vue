<template>
    <div class="container">
        <div class="col">
            <div>Список процедур</div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col-7">Название процедуры</th>
                    <th scope="col-1"></th>
                    <th scope="col-2"></th>
                    <th scope="col-2"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, number) in inputs">
                    <td scope="col-8">
                        {{ item.name_main_procedure }}
                    </td>
                    <td scope="col-1" v-on:click="change_procedure_name(item.id_main_procedure,item.name_main_procedure)" class="my_pointer">
                        &#128736
                    </td>
                    <td scope="col-2"><button type="button" class="btn btn-secondary" v-on:click="go_to_post(item.id_main_procedure)">Редактировать</button></td>
                    <td scope="col-2"><button type="button" class="btn btn-danger" v-on:click="delete_procedure(number,item.id_main_procedure)">Удалить</button></td>
                </tr>
                </tbody>
            </table>
            <hr align="center" width="90%" size="10" color="#dddddd" />

            <div v-if="show_textarea">

                <div class="div-block-31">
                    <div class="columns-4 w-row">
                        <div class="w-col w-col-3 w-col-medium-6">
                            <div class="link-block-4 w-inline-block">
                                <div class="text-block-16" >{{ text_area_message }}</div>
                                <div class="div-block-32" v-if="img_path_edit !='' " >
                                    <img :src="img_path_edit" alt="" class="image-8"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div>Редактирование изображения</div>
                <input type="file"
                       id="customFile"
                       @change="onAttachmentChange"
                >
                <textarea class="form-control" rows="2"  name="text" v-model="text_area_message"  v-bind:class="{border_alert: ch_name_danger_ans}" > </textarea>
                <button type="button" class="btn btn-primary btn-block procedure_button" v-on:click="save_change_procedure_name">Сохранить</button>
            </div>
            <textarea class="form-control" rows="2" id="messages" name="text" v-if="!show_textarea" v-bind:class="{border_alert: danger_ans}" v-model="message" placeholder="Введите название новой процедуры"> </textarea>
            <button type="button" class="btn btn-primary btn-block procedure_button" v-if="!show_textarea" v-on:click="add_new_line">Добавить процедуру</button>

        </div>

        <ul class="pagination">
            <li class="page-item page-link disabled my_pointer" v-on:click="prev">Previous</li>
            <li class="page-item page-link my_pointer" v-on:click="next">Next</li>
        </ul>

    </div>
</template>

<script>

    export default {
        data(){
            return {
                inputs: [],
                message: '' ,
                current_line: 0,
                procedure_number:0,

                danger_ans:false,
                //массив в который положится промежуточное значение постов
                removed:[],
                //текущий номер страницы пагинации
                pagination_numb:0,
                //количество постов всего ( для пагинации )
                posts_length:0,

                count_posts_arr:[],
                text_area_message:'',
                change_procedure_id_post:'',
                show_textarea:false,
                ch_name_danger_ans:false,
                user_info_var:'',
                img_path_edit:''
            }
        },

        props:['nazwanie_proc'],

    mounted() {
console.log(this.nazwanie_proc);
            this.render_start_array(this.inputs, this.removed, this.pagination_numb);
        this.user_info();
        },
        created(){
        },
        methods: {


            test (){
               console.log(this.img_path_edit)
            },

            user_info()
            {
                axios
                    .get('/auth/user',{
                    }).then(({ data }) => (
                        this.user_info_var=data
                    )
                );
            },

            onAttachmentChange (e) {
                this.attachment = e.target.files[0];
                this.submit();
            },
            submit () {
                // this.image_src='/avatars/3';

                const config = { 'content-type': 'multipart/form-data' };
                const formData = new FormData();


                formData.append('attachment', this.attachment);
                formData.append('post_id', this.$store.state.post_id);
                formData.append('procedure_id', this.change_procedure_id_post);
                axios.post('/store_pic_proc_list', formData, config,

                )
                    .then(response => {

                        if(response.data.status=='success')
                        {
                                this.img_path_edit = response.data.data
                        }
                        else
                            (
                                this.mes_err=response.data.mes.image,
                                    this.mes_err=this.mes_err[0],
                                    this.showModal=true
                            )

                    })

                    .catch(error => console.log('error'))

            },

            save_change_procedure_name()
            {
                this.ch_name_danger_ans = false
                if(this.text_area_message==''||this.text_area_message==' ')
                {
                    this.ch_name_danger_ans = true;
                }
                else {
                    for (let i = 0; i < this.inputs.length; i++) {
                        if (this.inputs[i]['id_main_procedure'] == this.change_procedure_id_post) {
                            this.inputs[i]['name_main_procedure'] = this.text_area_message;
                            this.show_textarea = false;
                            axios
                                .post('/update_procedure_name', {
                                    id_post:this.$store.state.post_id,
                                    id_procedure: this.change_procedure_id_post,
                                    name_procedure: this.text_area_message
                                });
                        }
                    }
                }
            },

            change_procedure_name (id_procedure, name_procedure)
            {
                this.img_path_edit='';
                this.show_textarea = true;
                this.text_area_message = name_procedure;
                this.change_procedure_id_post=id_procedure;

                axios
                    .post('/get_img_proc_path', {
                        id_post:this.$store.state.post_id,
                        id_procedure: this.change_procedure_id_post,
                    }).then(response => {
                        if(response.data != '/img/procedures/') {
                            this.img_path_edit = response.data
                        }
                })

            },

            delete_procedure(numb_in_arr, numb)
            {
                axios
                    .post('/delete_procedure',{
                        id_post:this.$store.state.post_id,
                        id_procedure:numb,
                        name_post:this.$store.state.namePost,
                    });
                this.inputs.splice(numb_in_arr,1)
            },

            add_new_line()
            {

                this.danger_ans = false;
                if(this.message==''||this.message==' ')
                {
                    this.danger_ans = true;
                }
                else
                {
                    if(this.count_posts_arr.length!==0)
                    {
                        this.procedure_number = this.count_posts_arr[this.count_posts_arr.length - 1]['id_main_procedure'];
                    }
                    else
                    {
                        this.procedure_number = 0;
                    }
                    this.procedure_number++;
                    while(((this.pagination_numb+1) * 10)<(this.posts_length))
                    {
                        this.pagination_numb++
                    }
                    this.inputs=[];
                    axios
                        .post('/add_procedure',{
                            id_post:this.$store.state.post_id,
                            name_post:this.$store.state.namePost,
                            id_main_procedure:this.procedure_number,
                            name_main_procedure:this.message,
                            nazwanie:this.nazwanie_proc,
                            author:this.user_info_var.data.name + ' ' + this.user_info_var.data.surname,
                        }).then(({ data }) => (
                        this.message ='',
                            this.inputs=[],
                            this.render_start_array(this.inputs, this.removed, this.pagination_numb),
                            this.count_of_posts(this.count_posts_arr)
                    ))
                }
            },

            go_to_post(numb)
            {
                this.$store.dispatch('setCurrentMainProcedure', numb),
                Vue.router.push({name:'block_list'});

            },


            render_start_array(inp, removed, pagination_numb)
            {

                pagination_numb=pagination_numb*10;
                axios
                    .post('/render_procedures',{
                        id_post:this.$store.state.post_id,
                    }).then(({ data }) => (
                    //запишем количество постов
                        this.posts_length=data.length,
                        removed= data.splice(pagination_numb, 10),
                        removed.forEach(function(entry) {
                     if(removed.length==1&&removed[0].id_main_procedure==0)
                    {}
                    else{

                        inp.push({
                            name_main_procedure:entry.name_main_procedure,
                            id_main_procedure:entry.id_main_procedure,
                        });
                    }

                }),
                this.count_of_posts(this.count_posts_arr)
                    )

                )

            },

            count_of_posts(inp_arr)
            {
               // this.count_posts_arr=[];
                axios
                    .post('/render_procedures',{
                        id_post:this.$store.state.post_id,
                    }).then(({ data }) =>
                {
                    data.forEach(function(entry) {
                        inp_arr.push({
                            name_main_procedure:entry.name_main_procedure,
                            id_main_procedure:entry.id_main_procedure,
                        });
                    })
                }
                )
            },

            next()
            {
                if(((this.pagination_numb+1) * 10)<(this.posts_length))
                {
                    this.inputs=[];
                    this.pagination_numb++;
                    this.render_start_array(this.inputs, this.removed, this.pagination_numb);
                }

            },
            prev()
            {
                if(this.pagination_numb != 0)
                {
                    this.inputs=[];
                    this.pagination_numb--;
                    this.render_start_array(this.inputs, this.removed, this.pagination_numb);
                }

            },



        }

    }
</script>
