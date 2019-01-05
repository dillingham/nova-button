<template>
    <div class="flex border-b border-40 nova-button-wrapper" resource-id="2">
        <div class="w-1/5 py-6 px-8">
            <label class="inline-block text-80 pt-2 leading-tight"></label>
        </div>
        <div class="py-6 px-8 w-1/2">
            <button 
                @click="handle" 
                :disabled="loading" 
                :class="field.classes"
                class="btn btn-default btn-primary nova-button" 
            >{{ field.text }}</button>
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

                this.loading = false;

                this.$toasted.show(
                    this.__(this.field.successMessage),
                    {type: 'success'}
                );
            } catch (error) {
                this.$toasted.show(
                    this.__(this.field.errorMessage),
                    {type: 'error'}
                );
            }
        },
        post()
        {
            this.loading = true;

            let root = '/nova-vendor/nova-button/';

            return Nova.request().post(root + `${this.resourceName}/${this.resourceId}/${this.field.key}/`, {event: this.field.event});
        }
    }
}
</script>