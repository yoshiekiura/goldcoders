<template>
  <v-btn x-large outlined class="ma-2" min-width="250" height="200" text @click="func()">
    <v-list-item-avatar :color="color">
      <v-icon color="white">{{ icon }}</v-icon>
    </v-list-item-avatar>
    <v-list-item two-line>
      <v-list-item-content>
        <v-list-item-title>{{ name }}</v-list-item-title>
        <v-list-item-subtitle>{{ description }}</v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>
    <v-spacer />
    <v-icon color="grey" right>keyboard_arrow_right</v-icon>
  </v-btn>
</template>



<script>
export default {
  props: {
    icon: String,
    name: String,
    description: String,
    func: Function,
    color: {
      default: "#1867C0",
      type: String,
    },
  },
  data() {
    return {};
  },
};
</script>
