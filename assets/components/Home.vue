<template>
  <div class="container">
    <div class="list-group py-4">
      <div v-for="day in days" v-bind:class="{ active: day.isActive }" class="list-group-item">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">{{ day.moment.format('dddd') }}</h5>
          <small>{{ day.moment.format('l') }}</small>
        </div>
        <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
        <small>Donec id elit non mi porta.</small>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";

export default {
  name: "Home",
  computed: {
    days() {
      let now = moment(),
          start = moment().weekday(1),
          end = moment().weekday(7),
          days = [];

      while (start <= end) {
        let isActive = false;
        if (start.format('d') === now.format('d')) {
          isActive = true
        }

        days.push({moment: start.clone(), isActive: isActive});
        start.add(1, 'days');
      }

      return days;
    }
  }
}
</script>
