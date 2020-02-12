<template>

    <div>
        <body class="body-2">
            <div class="section">
                 <div class="div-screen-1">
                <div class="div-block-8">
                    <p class="paragraph exp">Список ваших документов</p>
                    <a class="button-5 w-button" v-for="(doc) in my_documents_array" v-on:click="download_document" >{{ doc.document_name  }}</a>

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
                my_documents_array:[]

            }
        },
        mounted() {

            this.render_star_arr(this.my_documents_array)
        },
        methods: {
            render_star_arr(inp)
            {
                axios
                    .post('/render_documents',{
                    }).then(({ data }) =>
                    {
                              data.forEach(function(entry) {
                                    if(entry.answer_text!==''){
                                        inp.push({
                                            id:entry.id,
                                            id_document:entry.id_document,
                                            document_name:entry.document_name,
                                        });
                                    }
                                })
                    }

                );
            },

            download_document(event)
            {
                console.log(event.target);

                let text_name='text/'+event.target.innerHTML+'.doc';
                console.log(text_name);
                event.target.href = text_name;
                event.target.setAttribute('download', text_name);
                event.target.click();
            },

            test()
            {
                // axios
                //     .post('/test',{
                //     })
            },




        },

    }
</script>

