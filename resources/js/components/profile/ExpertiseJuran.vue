<template>


    <div>
        <body class="body-2">

            <div class="div-block-31">

                <h1 class="heading">Экспертиза сделки</h1>

                <p class="paragraph exp">{{ post_name }}</p>


                <div class="div-block-31">
                    <div class="columns-4 w-row">

                        <div class="w-col w-col-3 w-col-medium-6" v-for="(post, number) in posts"  v-on:click="go_to_expertise_test(post.id_procedure,post.text)">
                            <a href="#" class="link-block-4 w-inline-block">
                                <div class="text-block-16">{{ post.text }}</div>
                                <div class="div-block-32" v-if="post.img_path_post !='/img/procedures/' ">
                                    <img :src="post.img_path_post"  alt="" class="image-8"/>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>



<!--                    </div>-->
<!--                </div>-->

<!--            </div>-->
        </body>
    </div>

</template>

<script>

    export default {

        data(){

            return {
                //главный массив постов
                posts: [],
                post_name:''

            }
        },
        mounted() {
            this.render_table(this.posts);
           // this.post_name=this.posts[0]['name_post'];
        },
        methods: {

            test()
            {
                // axios
                //     .post('/test',{
                //     })
            },

            render_table(inp)
            {
                axios
                    .post('/front_render_procedures',{
                    }).then(({ data }) => (
                                data.forEach(function(entry) {
                                inp.push({
                                    text:entry.name_main_procedure,
                                    id_procedure:entry.id_main_procedure,
                                    name_post:entry.name_post,
                                    img_path_post: '/img/procedures/'+entry.img
                                })
                            }),
              this.post_name=this.posts[0]['name_post']
                    )

                );
            },

            go_to_expertise_test(numb, text)
            {
                Vue.router.push({name:'expertise_test', params: { front_procedure_id:numb, front_text_procedure:text}});
            },

        },

    }
</script>
<style>
    .list-counter-square {
        list-style: none;
      counter-reset: list;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    .list-counter-square>div {
        position: relative;
        display: block;
        /*height: 2rem;*/
        line-height: 2rem;
        margin-left: 1.75rem;
        margin-bottom: .25rem;
        padding-left: 1rem;
        padding-right: .5rem;
        color: #fff;
        background: #55a79a;
        /*white-space: nowrap;*/
        border-radius: .25rem
    }

    .list-counter-square>div:last-child {
        margin-bottom: 0;
    }

    .list-counter-square>div::before {
        content: counter(list);
        counter-increment: list;
        position: absolute;
        left: -2rem;
        top: -.25rem;
        bottom: -.25rem;
        width: 2.5rem;
        height: 2.5rem;
        line-height: 2rem;
        border-radius: 1.25rem;
        border: .25rem solid #fff;
        text-align: center;
        color: #fff;
        background: #55a79a;
    }
</style>

