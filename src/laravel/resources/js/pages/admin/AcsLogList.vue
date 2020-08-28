<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header"></div>
            <div class="card-body">
                <DataTable
                    model="log"
                    :cols="['created_at','person_id', 'subject_id', 'description', 'model']"
                    :operations="['delete']"
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
