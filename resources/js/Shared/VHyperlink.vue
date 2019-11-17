<template>
  <inertia-link class="ibtn" style="color: black" :href="route(`${href}`)">
    <slot></slot>
  </inertia-link>
</template>


<script>
export default {
  props: {
    href: {
      type: String,
      default: "home"
    }
  }
};
</script>


