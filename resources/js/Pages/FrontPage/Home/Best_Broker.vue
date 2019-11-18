<template>
  <v-container fluid height="auto" style="background: white" class="py-12 my-12">
    <v-container>
      <p
        class="text-left headline font-weight-medium pd-12"
      >
        Best Brokers & Platforms At Your Fingertips
      </p>

      <v-row>
        <v-col cols="12" md="8" xs="12">
          <span class="pb-12 text-left subtitle-1 font-weight-light">
            Our traders can undertake the Challenge and
            <span class="colorblue">receive funding</span> using
            <span class="colorblue">platforms MetaTrader 4, MetaTrader 5 or cTrader</span>. Trading accounts are held at leading worldwide brokers. We are the only independent project that will let you choose your favourite broker. For more information about our partners, click on their logo.
          </span>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" md="8" xs="12">
          <v-row>
            <v-col justify="center" align="center">
              <div class="fakeimage" :style="{ backgroundImage: 'url(' + platforms_src + ')' }" />
            </v-col>
          </v-row>

          <v-row justify="center">
            <span class="pt-12 text-center subtitle-1 font-weight-light">
              Do you waver about which broker to choose?
              <span
                class="colorblue"
              >Then make the use of the Broker Review application</span>.
            </span>
          </v-row>
        </v-col>
        <v-col cols="12" md="4" xs="12" justify="center" align="center">
          <img class="imagesize" :src="image_src">
        </v-col>
      </v-row>
    </v-container>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      image_src: "/images/logo/pc_computer2.png",
      platforms_src: "/images/logo/platforms.png",
    };
  },
};
</script>


<style scoped>
.colorblue {
  color: #1447a0;
  font-weight: bold;
}
.imagesize {
  width: 354px;
  height: 253px;
}

.fakeimage {
  /* width: 585px; */
  width: 100%;
  height: 74px;
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center center;
}
</style>

