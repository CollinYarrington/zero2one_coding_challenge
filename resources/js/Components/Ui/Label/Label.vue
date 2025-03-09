<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: String,
    required: Boolean
});

</script>

<template>
    <label
        :class="[
            'text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70'
            ]"
    >
    <slot /> <span v-if="required" class="text-red-500"> * </span>
    </label>
</template>
