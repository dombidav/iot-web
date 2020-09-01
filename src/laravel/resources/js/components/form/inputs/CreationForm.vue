<template>
    <div class="row mb-2">
        <InputDevice v-if="model === 'device'" :device="model"/>
        <InputGroup v-else-if="model === 'group'" :group="model" />
        <InputLock v-else-if="model === 'lock'" :lock="model"/>
        <InputWorker v-else-if="model === 'worker'" :worker="model" />
    </div>
</template>

<script>
    import InputDevice from "./InputDevice";
    import InputGroup from "./InputGroup";
    import InputLock from "./InputLock";
    import InputWorker from "./InputWorker";

    export default {
        props:{
            model: {}
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
