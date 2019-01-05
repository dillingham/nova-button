<template>
    <nova-button v-bind="$props">
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    mounted()
    {
        console.log(this.$parent.resourceId)
    }
}
</script>
