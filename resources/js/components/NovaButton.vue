<template>
<span>
    <router-link 
        v-if="field.type == 'route'" 
        :to="field.route" 
        class="nova-button" 
        :class="field.classes"
        v-html="field.text"
    />
    <a 
        v-else-if="field.type == 'link'" 
        :href="field.link.href" 
        :target="field.link.target" 
        class="nova-button" 
        :class="field.classes"
        v-html="field.text"
    />
    <span v-else :class="ajaxClasses">
        <a 
            @click="handleClick"
            :class="field.classes"
            class="nova-button"
            v-html="field.text"
        />
    </span>
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
    },
    computed: {
        ajaxClasses: function()
        {
            return {'nova-button-submitting': this.submitting, 'nova-button-submitted': this.submitted}
        }
    }
}
</script>