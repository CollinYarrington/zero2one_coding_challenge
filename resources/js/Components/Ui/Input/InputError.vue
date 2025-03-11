<script setup>
defineProps({
    message: String
});
</script>
<template>
    <div>
        <p class="text-red-500">{{ message }}</p>
    </div>
</template>