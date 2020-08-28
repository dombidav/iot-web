<template>
    <div class="btn-group" role="group" aria-label="Operations">
        <router-link :to="`${model}/${item._id}/edit`" class="btn btn-primary" replace><i class="fas fa-edit"/> Edit</router-link>
        <button @click="deleteRecord" class="btn btn-danger">Delete <i class="fas fa-trash"/></button>
    </div>
</template>
<script>
    export default {
        name: 'OperationButtons',
        props: {
            item: {},
            model: {}
        },
        methods: {
            deleteRecord(){
                axios.delete(`${this.model}/${this.item._id}`).then(response => alert(response.message)).catch(e => console.log(e))
            }
        }
    }
</script>
