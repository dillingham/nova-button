<template>
    <div v-if="field.visible">    
        <span v-if="field.confirm == null" :class="{'block text-right': field.indexAlign == 'right'}">
            <nova-button 
                :field="field"
                :resourceName="resourceName"
                :resourceId="$parent.resource['id'].value"
                @finished="reload"
            />
        </span>
        <div v-else :class="{'block text-right': field.indexAlign == 'right'}">
            <span>
                <a
                    :class="field.classes"
                    v-html="field.text"
                    @click="openModal = true"
                />
            </span>
            <portal to="modals">
                <transition name="fade">
                     <modal v-if="openModal" @modal-close="openModal = false">
                         <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 460px;">
                            <div class="p-8">
                                <heading :level="2" class="mb-6" v-html="field.confirm.title"></heading>
                                <p class="text-80 leading-normal" v-html="field.confirm.body"></p>
                            </div>
                            <div class="border-t border-50 px-6 py-3 ml-auto flex items-center" style="min-height: 70px; flex-direction: row-reverse">
                                <a class="btn text-80 font-normal px-3 mr-3 btn-link" style="order:2;" @click.prevent="openModal = false">Cancel</a>
                                <nova-button 
                                    :field="field"
                                    :resourceName="resourceName"
                                    :resourceId="$parent.resource['id'].value"
                                    @finished="modalReload"
                                />
                            </div>
                         </div>
                    </modal>
                </transition>
            </portal>
        </div>
    </div>
</template>

<script>

import { queue } from '../queue.js';

export default {
    props: ['resourceName', 'field'],
    data() {
        return {
            openModal: false
        }
    },
    methods: {
        reload()  {
            if(this.field.reload && queue.allowsReload()) {
                window.setTimeout(() => {
                    this.$router.go()
                }, 200)
            }
        },
        modalReload()
        {
            window.setTimeout(() => {
                this.openModal = false;          
                this.reload()
            }, 400)
        }
    }
}
</script>
