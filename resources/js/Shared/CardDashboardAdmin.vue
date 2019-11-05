<template>
  <v-card class="pa-1 card-outter" min-height="170">
    <v-list-item align="center" justify="center">
      <v-list-item-title>
        <v-list-item-avatar :color="color">
          <v-icon class="white--text">{{ icon }}</v-icon>
        </v-list-item-avatar>
        <v-list-item-title>
          <span class="title font-weight-light">{{ name }}</span>
        </v-list-item-title>
      </v-list-item-title>
    </v-list-item>

    <v-list class="transparent">
      <v-list-item dense v-for="(detail,index) in details" :key="index">
        <v-list-item-icon>
          <v-icon>{{ detail.icon }}</v-icon>
        </v-list-item-icon>
        <v-list-item-title>{{ detail.name }}</v-list-item-title>
        <v-list-item-subtitle class="text-right">{{ detail.value }}</v-list-item-subtitle>
      </v-list-item>
    </v-list>
    <!-- <div class="card-actions">
      <v-divider class="mt-5"></v-divider>
      <v-card-actions v-if="actions.length">
        <v-spacer></v-spacer>
        <v-btn text v-for="(action,index) in actions" :key="index" @click="action.func()">
          <v-icon color="grey" left>info</v-icon>
          <span class="caption grey--text align-end">{{ action.text }}</span>
        </v-btn>
      </v-card-actions>
    </div>-->
  </v-card>
</template>

<script>
export default {
  props: {
    name: String,
    icon: String,
    color: {
      type: String,
      default: "#00CAE3"
    },
    details: Array,
    actions: Array
  },
  data() {
    return {};
  }
};
</script>



<style scoped>
.card-outter {
  position: relative;
  padding-bottom: 50px;
}

.card-actions {
  position: absolute;
  bottom: 0;
  width: 100%;
}
</style>
