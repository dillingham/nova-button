<template>
    <span :class="{'block text-right': field.indexAlign == 'right'}">
        <nova-button 
            :field="field"
            :resourceName="resourceName"
            :resourceId="$parent.resource['id'].value"
            @finished="reload"
        />
    </span>
</template>

<script>

import { queue } from '../queue.js';

export default {
    props: ['resourceName', 'field'],
    methods: {
        reload()  {
            if(this.field.reload && queue.allowsReload()) {
                window.setTimeout(() => {
                    this.$router.go()
                }, 400)
            }
        }
    }
}
</script>
