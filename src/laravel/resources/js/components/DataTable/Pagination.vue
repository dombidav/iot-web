<template>
    <nav class="row">
        <div class="col-md-6 text-left">
                        <span>
                            Showing {{meta.from}} to {{meta.to}} of {{ meta.total }} Entries
                        </span>
        </div>
        <div class="col-md-6 text-right">
            <button
                    :disabled="!meta.prev_page_url"
                    class="btn btn-primary"
                    @click="PrevPage">
                Prev
            </button>
            <button
                    :disabled="!meta.next_page_url"
                    class="btn btn-primary ml-2"
                    @click="NextPage">
                Next
            </button>
        </div>
    </nav>
</template>
<script>
    export default {
        name: 'Pagination',
        props: {
            PrevPage: {},
            NextPage: {},
            meta: {}
        }
    }
</script>
