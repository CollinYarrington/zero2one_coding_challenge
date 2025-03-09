<script setup>
import Navigation from '@/Components/Navigation.vue';
</script>
<template>
    <Navigation />
    <div class="bg-black min-h-screen">
        <slot />
    </div>
</template>