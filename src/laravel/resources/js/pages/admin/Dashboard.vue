<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">Admin Dashboard</div>
            <div class="card-body">
                Yey, admin dashboard
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header">User List... Maybe?</div>
            <div class="card-body">
                <userList/>
            </div>
        </div>
    </div>
</template>
<script>
    import userList from '../../components/UserList'
    export default {
        mounted() {
            //
        },
        components: {
            userList
        }
    }
</script>
