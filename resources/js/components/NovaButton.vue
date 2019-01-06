<template>
    <span :class="{'nova-button-submitting': submitting, 'nova-button-submitted': submitted}">
        <button 
            @click="handleClick"
            :class="field.classes"
            class="nova-button"
        >{{ field.text }}</button>
    </span>
</template>

<style>
    .nova-button-submitting {
        pointer-events: none;
        opacity: 0.7;
    }
    .nova-button-submitted {
        pointer-events: none;
        opacity: 0.1;
    }
</style>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    data: () => ({
        submitting: false,
        submitted: false
    }),
    methods: {
        async handleClick() {
            
            try {
                
                const response = await this.post();

                this.submitting = false;

                this.submitted = true;

                this.$emit('clicked');

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
            this.submitting = true;

            let root = '/nova-vendor/nova-button/';

            return Nova.request().post(root + `${this.resourceName}/${this.resourceId}/${this.field.key}/`, {event: this.field.event});
        }
    }
}
</script>