<template>
    <div class="row mb-2">
        <InputDevice v-if="model === 'device'" />
        <InputDevice v-if-else="model === 'group'" />
        <InputDevice v-if-else="model === 'lock'" />
        <InputDevice v-if-else="model === 'worker'" />
    </div>
</template>

<script>
    import InputDevice from "./InputDevice";
    export default {
        props:{
            model: {}
        },
        components:{
            InputDevice
        }
    }
</script>

<style scoped>

</style>
