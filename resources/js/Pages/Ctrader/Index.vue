<template>
<div>
  <p>Symbol</p>
  <p>tradedSide (buy or sell)</p>
  <p>lotsize /1000 = standard lot size</p>
  <p>NET PL === profit on positionCloseDetails</p>
</div>
</template>

<script>
export default {
  data: ()=> ({
    prev_cursor: null, // start with null and is replace by next if we fetch a new set of data
    // and reset back to null if we change limit, from and to
    next_cursor: null,
    limit: 25, // default and min 25 max 750
    fromTimeStamp: null, // format in unix time milliseconds
    toTimeStamp: null, // format in unix time milliseconds
  }),
}
</script>