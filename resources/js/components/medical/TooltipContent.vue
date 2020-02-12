<template>
    <div class="col">
        <div v-bind:style="{ opacity: opacity_numb }"  v-click-outside="onClickOutside"
             style="-webkit-transform:translate3d(40PX, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-moz-transform:translate3d(40PX, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-ms-transform:translate3d(40PX, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);transform:translate3d(40PX, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);"
             class="div-helper_menu">
            <div v-for="(item,i) in posts"  class="border_content " >

                <div v-if="item.is_img==1" v-on:click="change_text(i)" v-bind:class="{border_alert: elemInArr(i), div_margin: i != 0}" class="on_hover_div" >
                    <img :src="item.text">
                </div>

                <div v-else v-on:click="change_text(i)" v-bind:class="{border_alert: elemInArr(i) , div_margin: i != 0}" class="on_hover_div">
                    {{ item.text }}
                </div>



            </div>
            <div class="arrow">
            </div>
        </div>

        <div class="tooltip_nav" v-if="edit_content==0">
            <div>Введите текст контента</div>
        <textarea class=" " name="content_textea"  v-model="text_content"></textarea>

                <input type="file"
                       id="customFile"
                       @change="onAttachmentChange"
                >

            <button type="button" class="btn btn-secondary active btn-block" v-on:click="save(posts)" >Сохранить</button>

        </div>

        <div class="tooltip_nav" v-if="edit_content==1" v-on:click="edit_text_frame=1" v-click-outside="onClickOutside_frame">
            <div>Отредактируйте текст</div>
            <textarea class=" " name="content_textea"  v-model="text_content_edit" ></textarea>
            <button type="button" class="btn btn-secondary active btn-block" v-on:click="save_edit" >Сохранить изменения</button>
            <button type="button" class="btn btn-alert active " v-on:click="delete_block" >Удалить блок</button>
            <button type="button" class="btn btn-secondary  " v-on:click="up_block" >Вверх</button>
            <button type="button" class="btn btn-secondary " v-on:click="dawn_block" >Вниз</button>

        </div>

        <div class="tooltip_nav" v-if="edit_content==2" v-on:click="edit_text_frame=1" v-click-outside="onClickOutside_frame">
            <div>Редактирование изображения</div>
            <input type="file"
                   id="customFile1"
                   @change="onAttachmentChange1"
            >
            <button type="button" class="btn btn-secondary  " v-on:click="up_block" >Вверх</button>
            <button type="button" class="btn btn-secondary " v-on:click="dawn_block" >Вниз</button>
            <button type="button" class="btn btn-alert active " v-on:click="delete_block" >Удалить блок</button>
        </div>

        <modal_error v-if="showModal" @close_error="close_modal" :message='mes_err' >
            <h3 slot="link">Выберите блок</h3>
        </modal_error>

    </div>
</template>
<script>

    export default {

        data(){

            return {
                vcoConfig: {
                    handler: this.handler,
                    middleware: this.middleware,
                    events: ['dblclick', 'click'],
                    isActive: true
                },

                //главный массив постов
                posts: [],
                opacity_numb:1,
                text_content:'',
                image_src:'',
                edit_content:0,
                text_content_edit:'',
                numb_in_edit_arr:'',
                temp_arr:[],
                alarm_arr:[],
                edit_text_frame:0,
                showModal:false,
                mes_err:''
            }
        },
        mounted() {
            this.render_start_arr(this.posts);
        },
        methods: {

            test()
            {
              console.log(this.posts)
            },
            close_modal(data)
            {
                this.showModal = false;

            },
            onClickOutside (event, el) {
                if(this.edit_text_frame !=1)
                {
                    this.alarm_arr=[];
                    this.edit_content = 0;
                }
            },
            onClickOutside_frame(){
                this.edit_text_frame=0;
            },
            elemInArr(numb)
            {
                return this.alarm_arr.indexOf(numb) === -1 ? false : true
            },


            up_block()
            {
              if(this.numb_in_edit_arr != 0)
             {
                 axios
                     .post('/get_content_from_tooltip_db', {
                         post_id: this.$store.state.post_id,
                         current_main_procedure: this.$store.state.current_main_procedure,
                         block_id: this.$store.state.block_id,
                         serial_number: this.posts[this.numb_in_edit_arr]['serial_number']
                     }) .then(response => {
                     this.posts=[];
                     this.render_start_arr(this.posts);
                 })
                 this.edit_content = 0;
                 this.alarm_arr=[];
             }

            },


            dawn_block()
            {

                if((this.numb_in_edit_arr+1) != this.posts.length)
                {
                    axios
                        .post('/get_content_from_tooltip_db_dawn', {
                            post_id: this.$store.state.post_id,
                            current_main_procedure: this.$store.state.current_main_procedure,
                            block_id: this.$store.state.block_id,
                            serial_number: this.posts[this.numb_in_edit_arr]['serial_number']
                        }) .then(response => {
                        this.posts=[];
                        this.render_start_arr(this.posts);
                    })
                    this.edit_content = 0;
                    this.alarm_arr=[];

                }
            },

            delete_block()
            {

                console.log(this.numb_in_edit_arr);
                axios
                    .post('/delete_tooltip_block', {
                        post_id: this.$store.state.post_id,
                        current_main_procedure: this.$store.state.current_main_procedure,
                        block_id: this.$store.state.block_id,
                        serial_number: this.posts[this.numb_in_edit_arr]['serial_number']
                    })
                this.posts.splice(this.numb_in_edit_arr, 1);
                this.text_content_edit='';
                this.edit_content = 0;
                this.alarm_arr=[];

            },

            save_edit()
            {
                if(this.text_content_edit!='') {
                    this.posts[this.numb_in_edit_arr]['text'] = this.text_content_edit;
                    this.edit_content = 0;
                    this.save_edit_db(this.posts[this.numb_in_edit_arr]['text'], this.posts[this.numb_in_edit_arr]['serial_number']);
                    this.text_content_edit='';
                    this.alarm_arr=[];
                    this.edit_text_frame=0;
                }
            },

            change_text(numb_in_array)
            {
                if(this.alarm_arr[0] != numb_in_array) {
                    this.alarm_arr=[];
                    this.alarm_arr.push(numb_in_array);
                    if (this.posts[numb_in_array]['is_img'] == 0) {
                        this.edit_content = 1;
                        this.numb_in_edit_arr = numb_in_array;
                        this.text_content_edit = this.posts[numb_in_array]['text'];


                    } else {
                        this.edit_content = 2;
                        this.numb_in_edit_arr = numb_in_array;

                    }
                }
                else
                {
                    this.alarm_arr=[];
                    this.edit_content = 0;
                }
            },

            render_start_arr(inp)
            {
                axios
                    .post('/render_start_tooltip_content', {
                        post_id: this.$store.state.post_id,
                        current_main_procedure: this.$store.state.current_main_procedure,
                        block_id: this.$store.state.block_id,
                    }).then(({ data }) => (
                    data.forEach(function(entry) {
                        inp.push({
                            text: entry.content,
                            is_img: entry.is_img,
                            serial_number:entry.serial_number
                        })
                    })
                                        )
                            )

            },

            onAttachmentChange1 (e) {
                this.attachment = e.target.files[0];
                this.submit1();
            },
            submit1 () {
                // this.image_src='/avatars/3';

                const config = { 'content-type': 'multipart/form-data' };
                const formData = new FormData();


                formData.append('attachment', this.attachment);
                formData.append('post_id', this.$store.state.post_id);
                formData.append('current_main_procedure', this.$store.state.current_main_procedure);
                formData.append('block_id', this.$store.state.block_id);
                formData.append('serial_number', this.posts[this.numb_in_edit_arr]['serial_number']
            );
                axios.post('/edit_pic_tooltip', formData, config,

                )
                    .then(response => {
                        if(response.data.status=='success')
                        {
                            this.posts[this.numb_in_edit_arr]['text']=response.data.data;
                            this.alarm_arr=[];
                            this.edit_content = 0;
                            this.edit_text_frame=0;

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
                formData.append('current_main_procedure', this.$store.state.current_main_procedure);
                formData.append('block_id', this.$store.state.block_id);
                axios.post('/store_pic_tooltip', formData, config,

                )
                    .then(response => {

                        if(response.data.status=='success')
                        {
                            // this.image_src='/avatars/'+this.user_info_var.data.id+'_'+response.data.data

                            this.posts.push({
                                text: response.data.data,
                                is_img: 1,
                                serial_number:response.data.serial_number
                            });
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

            save_edit_db(text, serial_number) {

                    axios
                        .post('/edit_tooltip_text', {
                            post_id: this.$store.state.post_id,
                            current_main_procedure: this.$store.state.current_main_procedure,
                            block_id: this.$store.state.block_id,
                            text_content: text,
                            serial_number: serial_number
                        })


            },

            save(inp_arr) {
                if(this.text_content !='') {
                    this.posts.push({
                        text: this.text_content,
                        is_img: 0,
                        serial_number:0
                    })

                    axios
                        .post('/tooltip_add_text', {
                            post_id: this.$store.state.post_id,
                            current_main_procedure: this.$store.state.current_main_procedure,
                            block_id: this.$store.state.block_id,
                            text_content: this.text_content,
                        })
                        .then(({ data }) => (
                                    inp_arr[inp_arr.length-1]['serial_number']=data
                            )
                        )

                    this.text_content = '';
                    this.alarm_arr=[];

                }
            },

            render_path()
            {
                   // this.$store.state.post_id
                   // this.$store.state.current_main_procedure
                   // this.$store.state.block_id

            },
        },

    }
</script>
