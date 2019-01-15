<template>
    <div class="flex border-b border-40 nova-button-wrapper" v-if="field.visible">
        <div class="w-1/4 py-4">
            <label class="font-normal text-80">{{ field.label }}</label>
        </div>
        <div class="w-3/4 py-4">
            <nova-button v-bind="$props" @finished="reload" />
        </div>
    </div>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
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