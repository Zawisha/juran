<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        {{ text }} <router-link  :to="{ name:'login_juran'}"><a href="" class="link-4">Войти</a></router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

                text: 'Ваш аккаунт подтверждён. ',
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        created() {
            //console.log(this.$route.params.token);
            this.acceptUserToken();

        },
        methods: {
            acceptUserToken()
            {
                //login instead confirm
              //  axios
                  //  .post('/confirm',{
                      //  tok: this.$route.params.token})
                  //  .then( (response)  => {
                    //    this.text=response.data.status;
                 //   });

                this.$auth.login({
                    url: "/confirm",
                    params: {
                        tok: this.$route.params.token
                    },
                    success: function () {
                    },
                    error: function () {
                        this.error = true;
                    },
                    rememberMe: true,
                    redirect: '/',
                    fetchUser: true,
                });
                Vue.router.push({name:'/'});

            },




        }
    }
</script>
