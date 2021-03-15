<template>
    <div class="flex border-b border-40 nova-button-wrapper" v-if="field.visible">
        <div class="w-1/4 py-4">
            <label class="font-normal text-80">{{ field.label }}</label>
        </div>
        <div class="w-3/4 py-4">
            <span v-if="field.confirm == null">
                <nova-button
                    :field="field"
                    :resourceName="resourceName"
                    :resourceId="resourceId"
                    @finished="reload"
                />
            </span>
            <div v-else>
                <a :class="field.classes" v-html="field.text" @click="openModal = true" />
                <portal to="modals">
                    <transition name="fade">
                        <modal v-if="openModal" @modal-close="openModal = false">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 460px;">
                                <div class="p-8">
                                    <heading :level="2" class="mb-6" v-html="field.confirm.title"></heading>
                                    <p class="text-80 leading-normal" v-html="field.confirm.body"></p>
                                    <textarea v-if="field.reason != null"
                                              id="description"
                                              dusk="description"
                                              rows="3"
                                              required
                                              placeholder="Description"
                                              class="w-full form-control form-input form-input-bordered py-3 h-auto des"
                                              v-model="field.reason">
                                    >
                                     </textarea>
                                </div>
                                <div
                                    class="border-t border-50 px-6 py-3 ml-auto flex items-center"
                                    style="min-height: 70px; flex-direction: row-reverse">
                                    <a
                                        style="order: 2;"
                                        class="cursor-pointer btn text-80 font-normal px-3 mr-3 btn-link"
                                        @click.prevent="openModal = false">Cancel</a>
                                    <nova-button v-bind="$props" @finished="modalReload" />
                                </div>
                            </div>
                        </modal>
                    </transition>
                </portal>
            </div>
        </div>
    </div>
</template>

<script>

import { queue } from '../queue.js';

export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    data() {
        return {
            openModal: false
        }
    },
    methods: {
        reload() {
            if(this.field.reload && queue.allowsReload()) {
                window.setTimeout(() => {
                    this.$router.go()
                }, 200)
            }
        },
        modalReload() {
            window.setTimeout(() => {
                this.openModal = false;
                this.reload()
            }, 400)
        }
    }
}
</script>