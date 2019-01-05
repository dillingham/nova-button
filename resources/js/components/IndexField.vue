<template>
    <nova-button 
        :field="field" 
        :resourceName="resourceName" 
        :resourceId="$parent.resource['id'].value">
</template>

<script>
export default {
    props: ['resourceName', 'field']
}
</script>
