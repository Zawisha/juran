<template>
    <div class="col">
<div>Список субъектов пользователя </div>
        <button v-tooltip.top-center="msg">Hover me</button>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col-3">Полное наименование</th>
                <th scope="col-3">ФИО</th>
                <th scope="col-3">Редактировать</th>
                <th scope="col-3">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(subject, number) in subjects">
                <td scope="col-3">
                    {{ subject.polnoe_naimenovanie }}
                </td>
                <td scope="col-3">
                    {{ subject.FIO }}
                </td>
                <td scope="col-3"><button type="button" class="btn btn-secondary"  v-on:click="edit_subject(subject.id)">Редактировать</button></td>
                <td scope="col-3"><button type="button" class="btn btn-danger" v-on:click="delete_subject(subject.id, number)">Удалить</button></td>
            </tr>

            </tbody>
        </table>


        <div v-on:click="render_table(subjects)"><v-pagination v-if="total_pages!=0"  v-model="currentPage"  :page-count=total_pages :classes="bootstrapPaginationClasses"></v-pagination></div>
<!--        <button type="button" class="btn btn-primary btn-block procedure_button" v-on:click="test">test</button>-->





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
