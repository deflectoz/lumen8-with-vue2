<template>
  <div>
    <b-table :items="items" :fields="fields" responsive="sm" striped hover>
      <template #cell(actions)="row">
        <b-button
          size="sm"
          @click="info(row.item, row.index, $event.target)"
          class="mr-1"
        >
          Info modal
        </b-button>
        <b-button size="sm" @click="row.toggleDetails">
          {{ row.detailsShowing ? "Hide" : "Show" }} Details
        </b-button>
      </template>
    </b-table>
  </div>
</template>

<script>
export default {
  props: {
    items: Array,
    fields: Array,
  },
  methods: {
    editItem(item) {
      console.log(item);
    },
  },
};
</script>

<style scoped>
</style>