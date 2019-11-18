<template>
  <v-app>
    <core-toolbar />
    <v-content>
      <slot />
    </v-content>
    <core-footer-summary />
    <core-footer-info />
  </v-app>
</template>


<script>
import CoreToolbar from "@/Pages/FrontPage/Layout/CoreToolbar";
import CoreFooterSummary from "@/Pages/FrontPage/Layout/CoreFooterSummary";
import CoreFooterInfo from "@/Pages/FrontPage/Layout/CoreFooterInfo";

export default {
  components: {
    CoreToolbar,
    CoreFooterSummary,
    CoreFooterInfo,
  },
};
</script>
