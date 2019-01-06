<template>
    <span :class="{'nova-button-loading': loading}">
        <button 
            @click="handleClick"
            :class="field.classes"
            class="nova-button"
        >{{ field.text }}</button>
    </span>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    methods: {
        async handleClick() {
            
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