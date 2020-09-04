<template>
    <div class="row mb-2">
        <InputDevice v-if="model === 'device'" :device="model" :item="item"/>
        <InputGroup v-else-if="model === 'group'" :group="model" :item="item" />
        <InputLock v-else-if="model === 'lock'" :lock="model" :item="item"/>
        <InputWorker v-else-if="model === 'worker'" :worker="model" :item="item" />
    </div>
</template>

<script>
    import InputDevice from "./InputDevice";
    import InputGroup from "./InputGroup";
    import InputLock from "./InputLock";
    import InputWorker from "./InputWorker";

    export default {
        props:{
            model: {},
            item: {}
        },
        components:{
            InputDevice,
            InputGroup,
            InputLock,
            InputWorker
        }
    }
</script>

<style scoped>

</style>
