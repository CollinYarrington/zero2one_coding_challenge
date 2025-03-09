<script setup>

const props = defineProps({
    modelValue: String | Number,
    class: String,
    error: Boolean,
});

const emits = defineEmits(['update:modelValue']);

const modelValue = defineModel();
</script>

<template>
    <input
        v-model="modelValue"
        :class="[
            'p-2 border-2 rounded-lg focus-visible:ring-blue-400  focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-1',
            {
                'border-red-500': error
            }
        ]"
    />
</template>

