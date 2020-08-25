<template>
    <div id="main">
        <header id="header">
            <Menu></Menu>
        </header>
        <div id="content">
            <Sidebar v-if="$auth.check()" />
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import Menu from './components/Menu.vue'
    import Sidebar from './components/Sidebar/Sidebar.vue'
    export default {
        data() {
            return {
                //
            }
        },
        components: {
            Menu,
            Sidebar
        }
    }
</script>
