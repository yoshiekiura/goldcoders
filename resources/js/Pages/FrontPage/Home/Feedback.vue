<template>
  <v-container fluid height="auto" style="background: #FFFFFF" class="py-12 my-12">
    <p
      class="text-center headline font-weight-medium"
    >
      Feedback From Our Traders On Forex Factory And Forex Peace Army
    </p>

    <v-carousel hide-delimiters height="auto">
      <v-carousel-item v-for="(item,i) in items" :key="i" :src="platforms_src">
        <v-row class="fill-height" align="center" justify="center">
          <v-col justify="center" align="center" cols="12" md="10" sm="12">
            <img class="fakeimage" :src="item.src">
          </v-col>
        </v-row>
      </v-carousel-item>
    </v-carousel>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      items: [
        {
          src: "/images/feedback/image1.png",
        },
        {
          src: "/images/feedback/image2.png",
        },
        {
          src: "/images/feedback/image3.png",
        },
        {
          src: "/images/feedback/image4.png",
        },

      ],
    };
  },
};
</script>


<style scoped>
.fakeimage {
  height: 100%;
  width: 100%;
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center center;
}
</style>

