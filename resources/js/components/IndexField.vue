<template>
    <span :class="{'block text-right': field.indexAlign == 'right'}">
        <nova-button 
            :field="field"
            :resourceName="resourceName"
            :resourceId="$parent.resource['id'].value"
            @clicked="handleClick" />
    </span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    methods: {
        handleClick()  {
            if(this.field.reload) {
                this.$router.go()
            }
        }
    }
}
</script>
