<template>
<div>
    <div class="container w-container">
    <div>Ваш документ готов.</div>
    <div>
        <button type="button" class="btn btn-primary procedure_button" v-on:click="get_file" >Скачать документ</button>
<!--        <button type="button" class="btn btn-primary btn-block procedure_button" v-on:click="test" >test</button>-->

    </div>

    </div>
</div>


<!--    <div>-->
<!--    </div>-->

</template>

<script>

    export default {

        data(){

            return {
                //главный массив постов
                posts: [],
                post_name:'',

            }
        },
        props:['document_name'],
        mounted() {

        },
        methods: {

            test()
            {
                console.log(this.document_name)
            },
            get_file()
            {
                    var fileLink = document.createElement('a');

                    // fileLink.href = fileURL;
                    fileLink.href = 'text/'+this.document_name+'.doc';

                    fileLink.setAttribute('download', this.document_name+'.doc');

                    document.body.appendChild(fileLink);
                    fileLink.click();


            },


        },

    }
</script>
