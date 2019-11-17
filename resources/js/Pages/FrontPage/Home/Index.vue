<template>
  <front-layout>
      <funding></funding>
    <ftmo></ftmo>
    <feedback></feedback>
    <join-our-team></join-our-team>
  </front-layout>
</template>


<script>
import FrontLayout from "@/Layouts/FrontLayout";
import JoinOurTeam from "@/Pages/FrontPage/Home/Join_Our_Team";
import Feedback from "@/Pages/FrontPage/Home/Feedback";
import Ftmo from "@/Pages/FrontPage/Home/Ftmo";
import Funding from "@/Pages/FrontPage/Home/Funding";

export default {
  components: {
    FrontLayout,
    JoinOurTeam,
    Feedback,
    Ftmo,
    Funding
  }
};
</script>
