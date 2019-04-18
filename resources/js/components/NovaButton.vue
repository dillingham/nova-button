<template>
  <span v-if="field.visible">
    <router-link
      v-if="field.type == 'route'"
      :to="field.route"
      ref="novabutton"
      class="nova-button"
      v-html="buttonText"
      :class="buttonClasses"
      :style="{'min-width': buttonWidth}"
    />
    <a
      v-else-if="field.type == 'link'"
      ref="novabutton"
      v-html="buttonText"
      class="nova-button"
      :class="buttonClasses"
      :href="field.link.href"
      :target="field.link.target"
      :style="{'min-width': buttonWidth}"
    />
    <span v-else :class="ajaxClasses">
      <a
        ref="novabutton"
        v-html="buttonText"
        @click.once="handleClick"
        class="nova-button"
        :class="buttonClasses"
        :style="{'min-width': buttonWidth}"
      />
    </span>
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
  props: ["resource", "resourceName", "resourceId", "field"],
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
          event: this.field.event
        }
      );
    }
  },
  computed: {
    buttonText: function() {
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