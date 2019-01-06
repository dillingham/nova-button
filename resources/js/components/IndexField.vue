<template>
    <nova-button 
        v-if="visible"
        :field="field" 
        @clicked="visible = false"
        :resourceName="resourceName" 
        :resourceId="$parent.resource['id'].value">
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    data: () => ({
        visible: true
    })
}
</script>
