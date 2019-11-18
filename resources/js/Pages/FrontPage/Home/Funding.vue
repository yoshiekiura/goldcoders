<template>
  <v-container fluid color="#F8F8F9" height="auto" class="py-12 my-12">
    <p class="text-center headline font-weight-medium">We Are More Than Just a Funding Programme</p>
    <p
      class="pb-12 text-center subtitle-1 font-weight-medium"
    >
Find out how you can benefit with FTMO.
</p>

    <v-row justify="center">
      <div v-for="(item,index) in items" :key="index" class="px-5">
        <span class="d-block pb-2 text-center" style="max-width: 150px;">
          <v-icon x-large>{{ item.icon }}</v-icon>
        </span>

        <p
          class="d-inline-block font-weight-medium subtitle-1 text-center text-uppercase"
          style="line-height: 1.2em; max-width: 100px;"
        >
{{ item.text }}
</p>
      </div>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      items: [
        { text: "Performance Phychologist", icon: "fa-line-chart" },
        { text: "Custom Apps", icon: "fa-cloud-download" },
        { text: "Account Evaluation", icon: "fa-vcard-o" },
        { text: "Customer Support", icon: "fa-user-circle-o" },
        { text: "Trading Academy", icon: "fa-graduation-cap" },
      ],
    };
  },
};
</script>



