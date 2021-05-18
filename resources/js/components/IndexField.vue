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
            <a class="whitespace-no-wrap" :class="field.classes" v-html="field.text" @click="openModal = true" />
            <portal to="modals">
                <transition name="fade">
                     <modal v-if="openModal" @modal-close="openModal = false">
                        <form class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 460px;">
                            <div class="p-8">
                                <heading :level="2" class="mb-6" v-html="field.confirm.title"></heading>
                                <p class="text-80 leading-normal" v-html="field.confirm.body"></p>
                              <br>
                              <select v-if="field.chooseOption != null"
                                      id="paymentType"
                                      dusk="paymentType"
                                      required
                                      placeholder="Payment Type"
                                      class="w-full form-control form-input form-input-bordered py-3 h-auto des"
                                      v-model="field.chooseOption"
                              >
                                <option v-for="option in field.chooseOption[0]" v-bind:value="option">
                                  {{ option }}
                                </option>
                              </select>
                            </div>
                            <div
                                class="border-t border-50 px-6 py-3 ml-auto flex items-center"
                                style="min-height: 70px; flex-direction: row-reverse">
                                <a
                                    style="order:2;"
                                    @click.prevent="openModal = false"
                                    class="cursor-pointer btn text-80 font-normal px-3 mr-3 btn-link">{{ __('Cancel') }}</a>
                                <nova-button
                                    :field="field"
                                    @finished="modalReload"
                                    :resourceName="resourceName"
                                    :resourceId="$parent.resource['id'].value"
                                />
                            </div>
                        </form>
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
