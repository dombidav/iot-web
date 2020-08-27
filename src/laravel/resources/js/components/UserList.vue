<template>
    <div>
        <h3>User List</h3>
        <data-table
            id="data-table"
            :data="data"
            :columns="columns"
            @onTablePropsChanged="reloadTable">
            <div slot="filters" slot-scope="{ tableData, perPage }">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <select class="form-control" v-model="tableProps.length" @change="reloadTable">
                            <option :key="page" v-for="page in perPage">{{ page }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" v-model="tableProps.search" placeholder="Search User" @input="reloadTable"/>
                    </div>
                    <div class="col-md-2">
                        <a href="#" class="btn btn-primary"><i class="fas fa-plus"/></a>
                    </div>
                </div>
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
                    <OperationButtons :item="item" :model="model"/>
                </td>
            </tr>
            </tbody>
            <div slot="pagination" slot-scope="{ meta = data }">
                <Pagination :prev-page="() => changePage(meta.prev_page_url)" :next-page="() => changePage(meta.next_page_url)" :meta="meta"/>
            </div>
        </data-table>
    </div>
</template>
<script>
    import Pagination from "./Pagination"
    import OperationButtons from "./OperationButtons";

    /**
     * @link https://github.com/jamesdordoy/laravel-vue-datatable
     * @link https://jamesdordoy.github.io/laravel-vue-datatable/examples/override-filters
     */

    export default {
        data() {
            return {
                model: 'user',
                url: '/user',
                search: "",
                data: {},
                selectOptions: [],
                tableProps: {
                    search: '',
                    length: 10,
                    column: '_id',
                    dir: 'asc'
                },
                columns: [
                    {
                        label: 'ID',
                        name: '_id',
                        columnName: '_id',
                        orderable: true,
                    },
                    {
                        label: 'Name',
                        name: 'name',
                        columnName: 'name',
                        orderable: true,
                    },
                    {
                        label: 'Email',
                        name: 'email',
                        columnName: 'email',
                        orderable: true,
                    },
                    {
                        label: 'Operations',
                        name: 'operations',
                        columnName: 'email',
                        orderable: false,
                        meta: {
                            dontIterate: true
                        }
                    }
                ]
            }
        },
        created() {
            this.getData();
        },
        methods: {
            getData: function () {
                console.log(this.tableProps.length)
                axios.get(this.url, {
                    params: this.tableProps,
                    headers: {
                        'api-key': this.$auth.user().apiKey
                    }
                })
                    .then(response => {
                        this.data = response.data
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
        components: {OperationButtons, Pagination}
    }
</script>
