
<template>
  <v-menu v-model="value1" offset-y bottom left open-on-hover style="min-width: 48px; max-width: 50px">
    <template v-slot:activator="{ on }">
      <v-btn text v-on="on">
        <span class="hidden-sm-and-down mr-1" v-text="title" />
        <v-icon class="hidden-sm-and-down" color="white">arrow_drop_down</v-icon>
        <v-icon class="hidden-md-and-up">fa-handshake-o</v-icon>
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
      title: "Tradings",
      value1: "",
      items: [
        { text: "Blog", href: "#", icon: "fa-address-card" },
        { text: "Brokers", href: "#", icon: "fa-address-card" },
        { text: "Partners", href: "#", icon: "fa-address-card" },
        { text: "FTMO Videos", href: "#", icon: "fa-address-card" },
        { text: "Applications", href: "#", icon: "fa-address-card" },
        { text: "Account Analysis", href: "#", icon: "fa-address-card" },
        { text: "Performance Psychologist", href: "#", icon: "fa-address-card" },

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
