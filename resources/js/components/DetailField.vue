<template>
    <div class="flex border-b border-40 nova-button-wrapper" resource-id="2">
        <div class="w-1/5 py-6 px-8">
            <label class="inline-block text-80 pt-2 leading-tight"></label>
        </div>
        <div class="py-6 px-8 w-1/2">
            <button @click="handle" class="btn btn-default btn-primary nova-button" :class="field.classes">{{ field.text }}</button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    methods: {
        async handle() {
            try {
                const response = await this.post();

                this.$toasted.show(
                    this.__(field.successMessage),
                    {type: 'success'}
                );
            } catch (error) {
                this.$toasted.show(
                    this.__(field.errorMessage),
                    {type: 'error'}
                );
            }
        },
        post()
        {
            let root = '/nova-vendor/dillingham/nova-button/';

            return Nova.request().post(root + `${this.resourceName}/${this.resourceId}/${this.field.key}/`, {event: field.event});
        }
    }
}
</script>