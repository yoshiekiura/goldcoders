<template>
  <v-navigation-drawer v-model="drawer" app clipped right class="blue-grey darken-4">
    <v-list>
      <v-link
        title="Dashboard"
        href="dashboard"
        icon="dashboard"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        title="Logout"
        href="logout"
        icon="power_settings_new"
        link-color="white"
        active-color="#4db6ac"
        icon-color="#fafafa"
      />
    </v-list>
  </v-navigation-drawer>
  <!-- either use route name or full url link in href -->
</template>

<script>
import VLink from "../Shared/VLink";

export default {
  components: {
    VLink,
  },
  data: () => ({
    drawer: false,
    user: null,
  }),
  created() {
    let self = this;
    switch (self.$vuetify.breakpoint.name) {
    case "xs":
      return (self.drawer = false);
    case "sm":
      return (self.drawer = false);
    case "md":
      return (self.drawer = true);
    case "lg":
      return (self.drawer = true);
    case "xl":
      return (self.drawer = true);
    }
  },
  mounted() {
    let self = this;
    // eslint-disable-next-line no-undef
    Bus.$on("toggleRightDrawer", function() {
      self.drawer = !self.drawer;
    });
  },
};
</script>
