<template>
    <div class="btn-group" role="group" aria-label="Operations">
        <a :href="`${model}/${item._id}/edit`" class="btn btn-primary"><i class="fas fa-edit"/> Edit</a>
        <a href="#" class="btn btn-danger">Delete <i class="fas fa-trash"/></a>
    </div>
</template>
<script>
    export default {
        name: 'OperationButtons',
        props: {
            item: {},
            model: {}
        }
    }
</script>