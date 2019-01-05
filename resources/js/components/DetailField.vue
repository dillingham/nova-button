<template>
    <div class="flex border-b border-40 nova-button-wrapper" v-if="field.visible">
        <div class="w-1/4 py-4">
            <label class="font-normal text-80"></label>
        </div>
        <div class="w-3/4 py-4">
            <button 
                @click="handle" 
                :disabled="loading" 
                :class="field.classes"
                class="nova-button" 
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

                this.field.visible = false;

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