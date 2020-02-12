<template>


    <div>
        <body class="body-2">
        <div class="section">
            <div class="div-screen-1"><div class="div-block-8"><h1 class="heading">Экспертиза сделки</h1>

                <p class="paragraph exp vopros">Выбрана экономическая концентрация :</p>
                    <div class="div-block-9"><div class="text-block-2">{{ test_front_text_procedure }}</div></div>
                    <div class="div-block-10"><div class="text-block-3"><div id="qwe">Ответьте на следующие вопросы</div></div>
                        <div class="columns-2 w-row columns-quest" v-for="(post, number) in blocks" >

                            <div class="column-6 w-col w-col-1 w-col-small-1 w-col-tiny-1">
                            <div class="div-block-14" v-if="number != (blocks.length-1)">
                 <img src="https://uploads-ssl.webflow.com/5d93c99b337fd39ab87ef61a/5d9a604c574a7da7ff2a659e_checked-symbol.png" alt="" class="image-3"/>
                            </div>
                        </div>
                            <div class="column-5 w-col w-col-11 w-col-small-11 w-col-tiny-11">
                                <div class="div-block-13">


<!--                                    tooltip-->
                                        <img v-if="in_arr_tool(number)"  src="https://uploads-ssl.webflow.com/5d93c99b337fd39ab87ef61a/5db602e6da948257ebec2565_help-none.svg" width="32" height="32" data-w-id="3a86d1b2-e2a9-b85e-24f7-98745b5cbad4" alt="" class="image-9"
                                        @click="change_opacity(number)"
                                        />
         <div  v-bind:id="number + 'op'"
              style="-webkit-transform:translate3d(40PX, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-moz-transform:translate3d(40PX, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-ms-transform:translate3d(40PX, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);transform:translate3d(40PX, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);"
              class="div-helper">
             <div v-for="(item,i) in posts[number]"  class="border_content " >

                 <div v-if="item.is_img==1" >
                     <img :src="item.text">
                 </div>

                 <div v-else >
                     {{ item.text }}
                 </div>

             </div>
             <div class="arrow"></div>
         </div>

<!--                                    tooltip_end-->

    <div class="text-block-4" v-html="post.question_text" >{{ post.question_text }}</div>
                        <div class="div-block-11"  >

                        <div  class="button-5 yes myButton" v-for="(question, numb) in post.answer_text"
                            v-bind:id="number + 'q' + numb" v-if="(post.answer_link_id[numb] !==0)&(question != '')" v-on:click="front_render_add_block(blocks,post.answer_link_id[numb],number,number + 'q' + numb)"

                        >{{ question }}</div>
                    </div>
                            <div class="div-block-11 final"
                                v-if="(post.answer_text ==((''))||(
                        post.answer_link_id.every(isNullElem)
                        )) ">
                                <div  class="button-5 yes new w-button" v-on:click="refresh_expertise()" >Начать сначала</div>
                                <router-link  :to="{ name: 'expertise_juran' }"><div class="button-5 yes new w-button">Новая экспертиза</div></router-link>
                            </div>

                            <div>

                            </div>

                        <div class="div-block-12" v-if="number != (blocks.length-1)">
                        <div class="text-block-5"  >Выбран ответ: {{ answer_choose_arr[number]}}</div>
                        </div>

                        </div>
                            </div>
                    </div>

                </div>

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
                msg:'',
                //главный массив блоков
                 blocks: [],
//current number of id block
                id_procedure:0,
                test_front_text_procedure:this.front_text_procedure,
                answer_choose_arr:[],
                tooltips_arr:[],
                opacity_numb_arr: [],
                posts: [],
                visible:[],
                opac:[]

            }
        },
        props:['front_procedure_id', 'front_text_procedure'],
        beforeMount() {
            this.render_start_block(this.blocks, this.posts);

        },
        mounted() {
            // this.render_start_block(this.blocks, this.posts);
            // this.render_start_arr_tooltips(this.posts);
        },
        methods: {
            test()
            {
                console.log(this.opacity_numb_arr[0]);

            },

            in_arr_tool(numb)
            {

                    if (this.posts[numb].length > 0) {
                        return true;
                    }
               // return true;
            },
            change_opacity(number)
            {



                let elem = document.getElementById(number+'op');
                let el_st = elem.style.opacity;
                if(el_st==0)
                {
                    var elements = document.getElementsByClassName('div-helper');
                    let i;
                    for (i = 0; i < elements.length; i++) {
                        elements[i].style.opacity = 0;
                    }
                    elem.style.marginLeft ="454px";
                     elem.style.opacity =1;
                }
                else
                {
                    elem.style.opacity =0;
                    elem.style.marginLeft ="474px";
                }

            },

            render_start_arr_tooltips(inp)
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

            render_start_tooltips(block_number)
            {
                let text =  this.blocks[block_number]['question_text'];
                let reg_text = text.match(/\[\|([a-zA-Zа-яА-ЯЁё0-9]+)\|\]/g);
                if(reg_text != null) {

                    let reg_text_inner = [];
                    for (let i = 0; i < reg_text.length; i++) {
                        let reg_text_r = reg_text[i].match(/\[\|([a-zA-Zа-яА-ЯЁё0-9]+)\|\]/);
                        reg_text_inner.push(reg_text_r[1]);
                    }

                    if (reg_text_inner.length != 0) {
                        axios
                            .post('/tooltip_get_arr', {
                                tooltip_arr: reg_text_inner
                            }).then(({data}) => (
                                this.tooltips_arr = data
                            )
                        )
                            .then(response => {

                                let array_words = text.split(' ');
                                let res_arr = '';
                                let copy = this.tooltips_arr;

                                array_words.forEach(function (item, i) {
                                    let flag = 0;
                                    let tooltip_name = '';
                                    let tooltip_descr = '';
                                    copy.forEach(function (tooltip_item) {


                                        if ('[|' + tooltip_item['abbreviation_name'] + '|]' == item) {
                                            flag = 1,
                                                tooltip_name = tooltip_item['abbreviation_name']
                                            tooltip_descr = tooltip_item['abbreviation_description']

                                        }
                                    });

                                    if (flag == 1) {
                                        item = "<button class='tool_under' classes=['info'] effect='light' tooltip='" + tooltip_descr + "'>" +
                                            tooltip_name +
                                            "</button>"

                                    }
                                    item += ' ';
                                    res_arr += item;
                                })
                                this.blocks[block_number]['question_text'] = res_arr.trim();
                            })
                    }
                }

            },

            isNullElem(number)
            {
                return number == 0;
            },

            go_to_expertise()
            {
                Vue.router.push({name:'expertise'});
            },

            refresh_expertise()
            {
                this.blocks=[];
                this.render_start_block(this.blocks, this.posts);
            },

            render_start_block(inp, inp_tooltips)
            {
                let temp_arr=[];
                let temp_arr_data=[];

                axios
                    .post('/front_render_start_block',{
                        id_procedure:this.front_procedure_id,
                    })
                        .then(({ data }) => (
                            temp_arr_data.push({
                            id_post:data.id_post,
                            id_procedure:data.id_procedure,
                            id_block:data.id_block,
                            block_name:data.block_name,
                            question_text:data.question_text,
                            answer_text:data.answer_text,
                            answer_link_id:data.answer_link_id,
                        })
                            ,
                            axios
                                .post('/render_start_tooltip_content', {
                                    post_id: temp_arr_data[0]['id_post'],
                                    current_main_procedure: temp_arr_data[0]['id_procedure'],
                                    block_id: temp_arr_data[0]['id_block'],
                                }).then(({ data }) => (
                                    data.forEach(function(entry) {
                                        temp_arr.push({
                                            text: entry.content,
                                            is_img: entry.is_img,
                                            serial_number:entry.serial_number
                                        })
                                    }),
                                this.posts[0]=temp_arr,
                                this.blocks = temp_arr_data,
                                this.opacity_numb_arr[0]=0,
                                this.render_start_tooltips(0)
                                )
                            )

                    )

                )

            },

            front_render_add_block(inp, id_block, number_in_array, number_clicked_button)
            {
                let temp_arr=[];
                let temp_arr_data=[];

                let elem = document.getElementById(number_clicked_button);
                this.answer_choose_arr[number_in_array]=elem.innerHTML;

                let a = elem.id.split('q')[0];
                let elems = document.getElementsByClassName('myButton');
                for (let i=0; i<elems.length; i++) {
                    if(a == elems[i].id.split('q')[0]) {
                        // $(elems[i]).removeClass( "passive" );
                        $(elems[i]).addClass( "noactive " );
                        $(elems[i]).addClass( "passive " );
                    }
                }
                $( elem).removeClass( "noactive" );
                $( elem).addClass( "passive" );
                // $( elem).addClass( "noactive " );

                this.id_procedure=this.blocks[0]['id_procedure'];
                if(number_in_array !==(inp.length-1))
                {
                    inp.splice(number_in_array+1);
                }

                axios
                    .post('/front_render_add_block',{
                        id_procedure:this.id_procedure,
                        id_block:id_block
                    })

                    .then(({ data }) => (
                        temp_arr_data.push({
                            id_post:data.id_post,
                            id_procedure:data.id_procedure,
                            id_block:data.id_block,
                            block_name:data.block_name,
                            question_text:data.question_text,
                            answer_text:data.answer_text,
                            answer_link_id:data.answer_link_id
                        })
                    ,

                                        axios
                                            .post('/render_start_tooltip_content', {
                                                post_id: temp_arr_data[0]['id_post'],
                                                current_main_procedure: temp_arr_data[0]['id_procedure'],
                                                block_id: temp_arr_data[0]['id_block'],
                                            }).then(({ data }) => (
                                                data.forEach(function(entry) {
                                                    temp_arr.push({
                                                        text: entry.content,
                                                        is_img: entry.is_img,
                                                        serial_number:entry.serial_number
                                                    })
                                                }
                                                ),

                this.posts[this.posts.length]=temp_arr,
                this.blocks.push(temp_arr_data[0]),
                this.render_start_tooltips(number_in_array + 1)
                                            )
                                        )
                    )

                )






                    // .then(({ data }) => (
                    //         inp.push({
                    //             id_post:data.id_post,
                    //             id_procedure:data.id_procedure,
                    //             id_block:data.id_block,
                    //             block_name:data.block_name,
                    //             question_text:data.question_text,
                    //             answer_text:data.answer_text,
                    //             answer_link_id:data.answer_link_id
                    //         })
                    //     )
                    //
                    // )
                    //
                    // .then(({ data }) => (
                    //
                    //         this.render_start_tooltips(number_in_array + 1),
                    //             axios
                    //                 .post('/render_start_tooltip_content', {
                    //                     post_id: inp[inp.length-1]['id_post'],
                    //                     current_main_procedure: inp[inp.length-1]['id_procedure'],
                    //                     block_id: inp[inp.length-1]['id_block'],
                    //                 }).then(({ data }) => (
                    //                     data.forEach(function(entry) {
                    //                         temp_arr.push({
                    //                             text: entry.content,
                    //                             is_img: entry.is_img,
                    //                             serial_number:entry.serial_number
                    //                         })
                    //                     })
                    //
                    //                 )
                    //             ),
                    //             this.posts[this.posts.length]=temp_arr
                    //     )
                    // )

            },


        },

    }
</script>
