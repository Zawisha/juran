<template>
    <div class="col">
        <div class="div-block-31">
            <h1 class="heading">База субъектов</h1>
            <div class="div-block-36">
                <div class="w-row"><div class="col-name w-col w-col-3">
                    <div class="div-name">
                        <div class="name">Наименование организации</div>
                    </div>
                </div>
                    <div class="col-name w-col w-col-3">
                        <div class="div-name">
                            <div class="name">ФИО</div>
                        </div>
                    </div>
                    <div class="w-col w-col-3">
                        <div class="name">УНП</div>
                    </div>
                    <div class="w-col w-col-3">
                        <div>
                            <div class="name">Статус</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="div-block-36 my_pointer" v-for="(subject, number) in subjects" v-on:click="edit_subject(subject.id)">
                <div class="w-row">
                    <div class="w-col w-col-3">
                        <div class="name"> {{ subject.polnoe_naimenovanie }}</div>
                    </div>
                    <div class="w-col w-col-3">
                        <div>{{ subject.FIO }}</div>
                    </div>
                    <div class="w-col w-col-3">
                        <div>
                            <div class="text-block-19">{{ subject.UNP }}</div>
                        </div>
                    </div>
                    <div class="w-col w-col-3">
                        <div>
                            <div class="text-block-20">{{ subject.status }}</div>
                        </div>
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
                msg:'tratata',
                subjects: [],
                title: 'test',
                currentPage: 1,
                total_pages:0,
                bootstrapPaginationClasses: {
                    ul: 'pagination',
                    li: 'page-item',
                    liActive: 'active',
                    liDisable: 'disabled',
                    button: 'page-link'
                },

            }
        },
        mounted() {
            this.render_table(this.subjects);
        },

        methods: {
// test()
// {
//     console.log(this.users);
// },


            render_table(inp)
            {

                axios
                    .post('/subject_list_pagination',{
                        offset:this.currentPage,
                    })
                    .then(({ data }) => (
                        inp=[],
                                data.forEach(function(entry) {
                                    inp.push({
                                    id:entry.id,
                                    polnoe_naimenovanie:entry.polnoe_naimenovanie,
                                    FIO:entry.FIO,
                                    UNP:entry.UNP,
                                    status:entry.status
                                });
                        }),
                        this.subjects=inp
                    )

                );

                this.getTotalCountSubjects();

            },

            getTotalCountSubjects()
            {
                axios
                    .post('/subjects_list',{
                    }).then(({ data }) => (
                        this.total_pages=Math.ceil((data.length)/10)
                ));
            },

            edit_subject(numb)
            {
                Vue.router.push({name:'edit_sub', params: { id_subject:numb}});
            },
            delete_subject(numb, numb_in_arr)
            {
                // console.log('nomer posta' + numb);
                // console.log('nomer stroki' + numb_in_arr);
                axios
                    .post('/delete_subject',{
                        id_subject:numb,
                    });
                this.subjects.splice(numb_in_arr,1)
            },



        },

    }



</script>
