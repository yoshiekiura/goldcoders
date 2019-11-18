<template>
  <v-menu v-model="value" offset-y bottom left open-on-hover>
    <template v-slot:activator="{ on }">
      <v-btn text v-on="on">
        <span class="hidden-sm-and-down mr-1" v-text="title" />
        <v-icon class="hidden-sm-and-down" color="white">arrow_drop_down</v-icon>
        <v-icon class="hidden-md-and-up">perm_contact_calendar</v-icon>
      </v-btn>
    </template>
    <v-list>
      <v-list-item v-for="(item, index) in items" :key="index" ripple="ripple" :href="item.href">
        <v-list-item-title class color="primary">{{ item.text }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
export default {
  data() {
    return {
      title: "Contact",
      value: "",
      items: [
        { text: "Contact", href: "#", icon: "fa-address-card" },
        { text: "About Us", href: "#", icon: "fa-signal" },
      ],
    };
  },
};
</script>


<style>
.tbhoverprimary:hover {
  color: var(--v-primary-base);
}
</style>
