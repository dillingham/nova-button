<template>
    <nova-button 
        :field="field" 
        v-if="field.visible"
        :resourceName="resourceName" 
        :resourceId="$parent.resource['id'].value">
</template>

<script>
export default {
    props: ['resourceName', 'field']
}
</script>
