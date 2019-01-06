<template>
    <nova-button 
        v-if="visible"
        :field="field"
        :resourceName="resourceName" 
        :resourceId="$parent.resource['id'].value">
</template>

<script>
export default {
    props: ['resourceName', 'field']
}
</script>
