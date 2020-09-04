<template>
    <div>
        <h3>{{ model.charAt(0).toUpperCase() + model.slice(1) }} List</h3>
        <data-table
            id="data-table"
            :data="data"
            :columns="columns"
            @onTablePropsChanged="reloadTable">
            <div slot="filters" slot-scope="{ perPage }">
                <CreationForm :model="model" v-show="formActive" :item="recordObject.item" />
                <TableHeader @addClick="formSwitch" :model="model" :per-page="perPage" :reload-table="reloadTable" :table-props="tableProps"/>
            </div>
            <tbody slot="body" slot-scope="{ data }">
            <tr
                :key="item._id"
                @click="showRowNumber(item._id)"
                v-for="item in data">
                <!-- TODO: Hover Effect? -->
                <td
                    :key="column.name"
                    v-for="column in columns.filter(c => !c.meta || !c.meta.dontIterate)">
                    <data-table-cell
                        :value="item"
                        :name="column.name"
                        :meta="column.meta"
                        :comp="column.component"
                        :classes="column.classes">
                    </data-table-cell>
                </td>
                <td>
                    <OperationButtons :item="item" :model="$attrs.model" @updateClicked="updateClicked"/>
                </td>
            </tr>
            </tbody>
            <div slot="pagination" slot-scope="{ meta = data }">
                <Pagination :prev-page="() => changePage(meta.prev_page_url)"
                            :next-page="() => changePage(meta.next_page_url)" :meta="meta"/>
            </div>
        </data-table>
    </div>
</template>
<script>
    import Pagination from "../../components/DataTable/Pagination"
    import OperationButtons from "../../components/DataTable/OperationButtons";
    import TableHeader from "../../components/DataTable/TableHeader";
    import CreationForm from "../form/inputs/CreationForm";

    /**
     * @link https://github.com/jamesdordoy/laravel-vue-datatable
     * @link https://jamesdordoy.github.io/laravel-vue-datatable/examples/override-filters
     */

    export default {
        params: {
            model: '',
            cols: [],
            operations: []
        },
        data() {
            return {
                formActive: false,
                model: '',
                url: '',
                search: "",
                data: {},
                selectOptions: [],
                tableProps: {
                    search: '',
                    length: 10,
                    column: '_id',
                    dir: 'asc'
                },
                recordObject: {},
                columns: []
            }
        },
        created() {
            this.fetchModel();
            this.fetchCols();
            this.getData()
        },
        methods: {
            updateClicked: function(x){
                this.formActive = true
                console.log(x)
                this.recordObject = x
            },
            formSwitch: function(){
                this.formActive = !this.formActive
            },
            fetchModel: function(){
              this.model = this.$attrs.model;
              this.url = '/' + this.$attrs.model
            },
            fetchCols: function() {
                for (const col of this.$attrs.cols){
                    this.columns.push({
                        label: col.charAt(0).toUpperCase() + col.slice(1),
                        name: col,
                        columnName: col,
                        orderable: true
                    })
                }
                this.columns.push({
                    label: 'Operations',
                    name: 'operations',
                    columnName: 'operations',
                    orderable: false,
                    meta: {
                        dontIterate: true
                    }
                })
            },
            getData: function () {
                axios.get(this.url, {
                    params: this.tableProps,
                    headers: {
                        'api-key': this.$auth.user().apiKey
                    }
                })
                    .then(response => {
                        this.data = response.data
                        //console.log(response)
                    })
                    .catch(errors => {
                        console.log(errors.message)
                    })
            },
            reloadTable() {

                this.getData();
            },
            showRowNumber(id) {
                //alert(`you clicked row ${id}`);
            },
            changePage(to) {
                if (to) {
                    this.url = to;
                    this.reloadTable();
                }
            }
        },
        components: {TableHeader, OperationButtons, Pagination, CreationForm},

    }
</script>
