<template>
  <v-navigation-drawer v-model="drawer" app class="blue-grey darken-4">
    <v-list color="primary">
      <v-list-item>
        <v-list-item-avatar>
          <v-img :src="$page.auth.user.avatar"></v-img>
        </v-list-item-avatar>
      </v-list-item>

      <v-list-item link>
        <v-list-item-content>
          <v-list-item-title class="title white--text">{{ $page.auth.user.fname }}!</v-list-item-title>
          <v-list-item-subtitle class="white--text">{{ $page.auth.user.email }}</v-list-item-subtitle>
        </v-list-item-content>

        <v-list-item-action>
          <v-icon color="white">mdi-menu-down</v-icon>
        </v-list-item-action>
      </v-list-item>
    </v-list>
    <v-divider></v-divider>
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
        title="Manage Users"
        href="users.index"
        icon="fa-users"
        link-color="white"
        active-color="#BA9A5a"
        icon-color="#fafafa"
      />
      <v-link
        title="Logout"
        href="logout"
        icon="power_settings_new"
        link-color="white"
        active-color="#BA9A5a"
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
    VLink
  },
  data: () => ({
    drawer: false,
    user: null
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
    Bus.$on("toggleDrawer", function() {
      self.drawer = !self.drawer;
    });
  }
};
</script>
