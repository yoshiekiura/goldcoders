<template>
  <v-container fluid height="auto" style="background: white" class="py-12 my-12">
    <v-container>
      <v-row>
        <v-col cols="12" justify="center" align="center" md="6" xs="12">
          <p class="text-center headline font-weight-medium pd-12">We Fund Good Traders</p>

          <p class="text-left subtitle-1 font-weight-light">
            FTMO developed a unique 2-step evaluation course for Forex Traders. This evaluation process consists of the
            <span
              class="colorblue"
            >Challenge</span>
            and the
            <span class="colorblue">Verification</span>
            and is specifically tailored to discover trading talents.
          </p>

          <p class="pb-12 text-left subtitle-1 font-weight-light">
            Upon successful completion of the trading course, you are guaranteed a placement in the FTMO Proprietary Trading firm where you can remotely manage funded account of up to
            <span
              class="colorblue"
            >100,000 USD</span>
            . Your journey to get there might be challenging, but our educational applications, account analysis and performance psychologist are here to guide you on the endeavour to financial independence.
          </p>
        </v-col>
        <v-col cols="12" justify="center" align="center" md="6" xs="12">
          <div>
            <iframe
              width="100%"
              height="320"
              src="https://www.youtube.com/embed/7DLObiJtKkM"
              frameborder="0"
              allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            />
          </div>
        </v-col>
        <v-col cols="12" justify="center" align="center" class="hidden-sm-and-down">
          <img class="fakeimage" :src="image_src">
        </v-col>
      </v-row>
    </v-container>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      image_src: "/images/logo/winnerof2019.jpg",
    };
  },
};
</script>

<style scoped>
.colorblue {
  color: #1447a0;
  font-weight: bold;
}

.fakeimage {
  width: 847px;
  height: 113px;
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center center;
}
</style>



