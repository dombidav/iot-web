<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header"></div>
            <div class="card-body">
                <DataTable
                    model="group"
                    :cols="['_id', 'name']"
                    :operations="['show','edit', 'delete']"
                />
            </div>
        </div>
    </div>
</template>
<script>
    import DataTable from '../../components/DataTable/DataTable'
    export default {
        mounted() {
            //
        },
        components: {
            DataTable
        }
    }
</script>
