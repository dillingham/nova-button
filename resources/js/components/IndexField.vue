<template>
    <span :class="{'block text-right': field.indexAlign == 'right'}">
        <nova-button 
            :field="field"
            :resourceName="resourceName"
            :resourceId="$parent.resource['id'].value" />
    </span>
</template>

<script>
export default {
    props: ['resourceName', 'field']
}
</script>
