<template>
  <button
    :type="type"
    v-on="$listeners"
    class="px-2.5 py-1.5 text-lg rounded text-white text-center transition"
  >
    {{ text }}
  </button>
</template>

<script>
export default {
  name: "BaseBtn",
  props: {
    type: {
      type: String,
      default: "submit",
    },
    text: {
      type: String,
      default: "Submit",
    },
  },
};
</script>
