<template>
    <div class="btn-group" role="group" aria-label="Operations">
        <button @click="updateRecord" class="btn btn-primary"><i class="fas fa-edit"/> Edit</button>
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
            },
            updateRecord(){
                this.$emit('updateClicked', this.item)
            }
        }
    }
</script>
