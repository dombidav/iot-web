<template>
    <div class="row mb-2">
        <div class="col-md-6">
            <select aria-label="Item count" class="form-control" v-model="tableProps.length" @change="reloadTable">
                <option :key="page" v-for="page in perPage">{{ page }}</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" v-model="tableProps.search" placeholder="Search" @input="reloadTable" aria-label="Search"/>
        </div>
        <div class="col-md-2">
            <a href="#" class="btn btn-primary"><i class="fas fa-plus"/></a>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'TableHeader',
        props: {
            perPage: {},
            reloadTable: {},
            tableProps: {}
        }
    }
</script>
