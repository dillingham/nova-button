<template>
    <div class="flex border-b border-40 nova-button-wrapper" v-if="field.visible">
        <div class="w-1/4 py-4">
            <label class="font-normal text-80"></label>
        </div>
        <div class="w-3/4 py-4">
            <nova-button v-bind="$props">
        </div>
    </div>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    mounted()
    {
        console.log(this.field);
    }
}
</script>