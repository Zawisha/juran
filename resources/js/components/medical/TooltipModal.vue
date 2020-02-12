<template>
    <transition name="parents_modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container1">

                    <div class="modal-header">
                        <slot name="link">
                        </slot>
                    </div>

                    <div class="modal-body">
                        <div>Введите новую аббревиатуру!!</div>
                        <div>
                            <textarea name="" id="abbr" cols="30" rows="3" v-model="text_abbr"></textarea>
                        </div>
                        <div>Введите новое описание</div>
                        <div>
                            <textarea name="" id="abbr_desk" cols="30" rows="3" v-model="desc_text_abbr"></textarea>
                        </div>
                        <div>Предыдущие аббревиатуры</div>
                        <v-select  v-model="select_abbr" :options="arr_m" placeholder="Выберите аббревиатуру" @search="getDBrequestAutocomplete" @input="getSelected"></v-select>

                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="modal-default-button"  @click="$emit('tooltip_close', {abbr_mod:text_abbr,
                    abbr_text_mod:desc_text_abbr})">
                                Сохранить
                            </button>
                            <button class="modal-default-button" @click="$emit('tooltip_close',
                            {abbr_mod:'',
                                 abbr_text_mod:''})"
                            >
                                Закрыть
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<script>
    export default {
        data(){
            return {
                modal_blocks: [],
                text_abbr:'',
                desc_text_abbr:'',
                arr_m:[],
                select_abbr:''

            }
        },

        //номер в массиве выбранного вопроса


        mounted() {


        },
        created(){
        },
        methods:
        {
            getSelected()
            {
                axios
                    .post('/get_abbr_descr',{
                        select_abbr:this.select_abbr

                    }).then(({ data }) => (
                        this.desc_text_abbr=data[0]['abbreviation_description'],
                        this.text_abbr=data[0]['abbreviation_name']
                    )
                );

            },

            modal_show_block_list(inp)
            {
               var block = this.$store.state.block_id;
                axios
                    .post('/render_blocks',{
                        id_post:this.$store.state.post_id,
                        id_procedure:this.$store.state.current_main_procedure,
                    }).then(({ data }) => (
                        data.forEach(function(entry) {
                            if(entry.id_block!= block)
                            {
                                inp.push({
                                    id_block:entry.id_block,
                                    block_name:entry.block_name,
                                });
                            }
                        })
                    )
                );

            },

            getDBrequestAutocomplete (input) {
                this.arr_m = [];
                if(input!='') {
                    let arr_md = [];
                    axios
                        .post('/get_autocomplete_tooltip', {
                            req_string: input,
                        })
                        .then(({data}) => {
                                data.forEach(function (entry) {
                                    arr_md.push(
                                        entry.abbreviation_name,
                                    );
                                })
                            }
                        )


                    return this.arr_m = arr_md;
                }
            },

        }
    }
</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container1 {
        width: 440px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
        overflow: auto;
        height: 400px;

    }

    .modal-default-button {
        float: right;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>
