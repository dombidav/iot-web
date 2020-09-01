<template>
    <section>

        <CreationForm :model="model" v-show="formActive"/>
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
                <button @click="() => this.formActive = !this.formActive" class="btn btn-primary"><i class="fas fa-plus"/></button>
            </div>
        </div>
    </section>
</template>
<script>
    import CreationForm from "../form/inputs/CreationForm";
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
                formActive: false
            }
        },
        components:{
            CreationForm
        }
    }
</script>
