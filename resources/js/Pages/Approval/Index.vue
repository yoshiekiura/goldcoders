<template>
  <main-layout :title="name">
    <v-container fluid>
      <v-row>
        <v-col cols="12">
          <v-row align="center" justify="center" class="grey lighten-5 py-12 my-12">
            <button-card
              v-for="(item,index) in details"
              :key="index"
              :icon="item.icon"
              :name="item.name"
              :description="item.description"
              :func="item.func"
            />
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
import ButtonCard from "@/Shared/ButtonCard";

export default {
  components: {
    MainLayout,
    ButtonCard,
  },

  data() {
    return {
      name: "Approval Manager",
      ifMemberOnly: false,
      details: [
        {
          icon: "fa-money",
          name: "payout",
          description: "for approval",
          func: () => this.payout(),
        },
        {
          icon: "fa-credit-card",
          name: "payment",
          description: "for approval",
          func: () => this.payment(),
        },
        {
          icon: "backup",
          name: "user file",
          description: "for approval",
          func: () => this.user_file_manager(),
        },
      ],
    };
  },

  created() {},
  methods: {
    payout() {
      this.$inertia.visit(this.route("approval.payout").url());
    },
    payment() {
      this.$inertia.visit(this.route("approval.payment").url());
    },
    user_file_manager() {
      this.$inertia.visit(this.route("approval.user.file").url());
    },
  },
};
</script>

<style scoped>
.btn {
  text-decoration: none;
}
</style>
