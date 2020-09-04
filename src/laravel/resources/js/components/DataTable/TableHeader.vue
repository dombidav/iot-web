<template>
    <section>
        <div class="row mb-2">
            <div class="col-md-6">
                <select aria-label="Item count" class="form-control" v-model="tableProps.length" @change="reloadTable">
                    <option :key="page" v-for="page in perPage">{{ page }}</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" v-model="tableProps.search" placeholder="Search" @input="reloadTable"
                       aria-label="Search"/>
            </div>
            <div class="col-md-2">
                <button @click="callForm" class="btn btn-primary"><i class="fas fa-plus"/></button>
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        name: 'TableHeader',
        props: {
            perPage: {},
            reloadTable: {},
            tableProps: {},
            model: {}
        },
        data(){
            return{
            }
        },
        methods:{
            callForm: function () {
                this.$emit('addClick')
            }
        }
    }
</script>
