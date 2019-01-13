<template>
<span>
    <router-link 
        v-if="field.type == 'route'" 
        :to="field.route" 
        class="nova-button"
        ref="novabutton" 
        :class="buttonClasses"
        :style="{ 'min-width': buttonWidth }"
        v-html="buttonText"
    />
    <a 
        v-else-if="field.type == 'link'" 
        :href="field.link.href" 
        :target="field.link.target" 
        class="nova-button"
        ref="novabutton" 
        :class="buttonClasses"
        :style="{ width: buttonWidth }"
        v-html="buttonText"
    />
    <span v-else :class="ajaxClasses">
        <a 
            @click="handleClick"
            :class="buttonClasses"
            class="nova-button"
            :style="{ 'min-width': buttonWidth }"
            ref="novabutton"
            v-html="buttonText"
        />
    </span>
</span>
</template>

<style>
    .nova-button-submitting {
        pointer-events: none;
        opacity: 0.5;
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
        buttonClasses: [],
        buttonWidth: null,
        submitting: false,
        submitted: false
    }),
    mounted()
    {
        this.buttonClasses = this.field.classes;

        this.$nextTick(function(){
            this.buttonWidth = this.$refs.novabutton.clientWidth + 2 + 'px';
        })
    },
    methods: {
        async handleClick() {
            try {
                const response = await this.post();

                this.submitting = false;

                this.submitted = true;

                this.$emit('clicked');

                if(this.field.reload == false) {
                    this.$toasted.show(
                        this.__(this.field.successMessage),
                        {type: 'success'}
                    );
                }
            } catch (error) {
                if(this.field.reload == false) {
                    this.$toasted.show(
                        this.__(this.field.errorMessage),
                        {type: 'error'}
                    );
                }
            }
        },
        post()
        {
            this.submitting = true;

            this.buttonClasses.push('text-center')

            let root = '/nova-vendor/nova-button/';

            return Nova.request().post(root + `${this.resourceName}/${this.resourceId}/${this.field.key}/`, {event: this.field.event});
        }
    },
    computed: {
        buttonText: function() {

            if(this.field.loadingText && this.submitting)
            {
                return this.field.loadingText;
            }

            return this.field.text;
        },
        ajaxClasses: function()
        {
            return {'nova-button-submitting': this.submitting, 'nova-button-submitted': this.submitted}
        }
    }
}
</script>