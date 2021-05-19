<template>
  <span v-if="field.visible" :class="ajaxClasses">
    <span
      ref="novabutton"
      class="nova-button"
      v-html="buttonText"
      @click="handleClick"
      :class="buttonClasses"
      :style="{'min-width': buttonWidth}"
      :title="field.title"
      :dusk="field.attribute"
    ></span>
  </span>
</template>

<style>
.nova-button {
  white-space: nowrap;
}
.nova-button-loading,
.nova-button-success,
.nova-button-error {
  pointer-events: none;
}
</style>

<script>
import { queue } from "../queue.js";

export default {
  props: ["resource", "resourceName", "resourceId", "field", "ajaxClasses"],
  data: () => ({
    buttonWidth: null,
    loading: false,
    success: false,
    error: false
  }),
  mounted() {
    this.$nextTick(function() {
      this.buttonWidth = this.$refs.novabutton.clientWidth + 2 + "px";
    });
  },
  methods: {
    async handleClick() {
      queue.add(this.resourceId);

      this.$emit("clicked");

      try {
        const response = await this.post();
        this.success = true;
        this.loading = false;
        queue.hasSuccess = true;
        queue.remove(this.resourceId);
        this.$emit("success");
        this.$emit("finished");
        this.navigate();
      } catch (error) {
        this.error = true;
        this.loading = false;
        queue.hasError = true;
        queue.remove(this.resourceId);
        this.$emit("error");
        this.$emit("finished");
      }
    },
    post() {
      this.$emit("loading");

      window.setTimeout(() => {
        this.loading = true;
      }, 200);

      let root = "/nova-vendor/nova-button/";

      return Nova.request().post(
        root + `${this.resourceName}/${this.resourceId}/${this.field.key}`,
        {
          event: this.field.event,
          chooseOption: this.field.chooseOption,
          note:  this.field.reason,
        }
      );
    },
    navigate() {
      if(this.field.type == 'route') {
        this.$router.push(this.field.route);
      }

      if(this.field.type == 'link') {
        window.open(this.field.link.href, this.field.link.target);
      }
    }
  },
  computed: {
    buttonText: function() {
      if(this.field.link && this.field.link.target == '_blank') {
        return this.field.text;
      }

      if (this.error && this.field.errorText) {
        return this.field.errorText;
      }

      if (this.success && this.field.successText) {
        return this.field.successText;
      }

      if (this.loading && this.field.loadingText) {
        return this.field.loadingText;
      }

      return this.field.text;
    },
    buttonClasses: function() {
      if(this.field.link && this.field.link.target == '_blank') {
        return this.field.classes;
      }
      if (this.error && this.field.errorClasses.length) {
        return this.field.errorClasses + " text-center nova-button-error";
      }

      if (this.success && this.field.successClasses.length) {
        return this.field.successClasses + " text-center nova-button-success";
      }

      if (this.loading && this.field.loadingClasses) {
        return this.field.loadingClasses + " text-center nova-button-loading";
      }

      return this.field.classes;
    }
  }
};
</script>
