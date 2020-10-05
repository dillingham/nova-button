import {queue} from './js/queue';

export default {
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
