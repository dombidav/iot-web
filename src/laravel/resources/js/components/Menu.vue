<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <router-link :to="{name: 'home'}" class="navbar-brand">IOT-WEB</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto" v-if="$auth.check()">
                <li>
                    <div class="dropdown" v-if="$auth.check()">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $auth.user().name }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <router-link :to="{name: 'home'}" class="dropdown-item">Profile</router-link>
                            <a class="dropdown-item" href="#" @click.prevent="logout">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
    export default {
        data() {
            return {
                routes: {
                    // UNLOGGED
                    unlogged: [
                        { name: 'Register', path: 'register' },
                        { name: 'Login', path: 'login'}
                    ],
                    // LOGGED ADMIN
                    admin: [
                        { name: 'Dashboard', path: 'dashboard' }
                    ]
                }
            }
        },
        methods: {
            logout: function () {
                $auth.logout();
                this.$router.push({path: '/'})
            }
        },
        mounted() {
            //
        }
    }
</script>
<style>
    .navbar {
        margin-bottom: 30px;
    }
</style>
