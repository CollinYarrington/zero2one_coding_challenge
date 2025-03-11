<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    feedback: Object
});

const userFeedback = ref();
watch(() => props.feedback,(update) => {
    userFeedback.value = update;
    setTimeout(() => userFeedback.value = null, 5000);
});

</script>

<template>
    <div :class="[
        'p-5 text-pretty fixed top-10 right-1/2 translate-x-1/2 rounded shadow-2xl',
        userFeedback?.status === 'success' ? 'bg-emerald-500' : 
        userFeedback?.status === 'warning' ? 'bg-yellow-500' : 
        userFeedback?.status === 'error' ? 'bg-red-500' : ''
    ]">
        <div v-if="userFeedback?.message">
            {{ userFeedback?.message }}
        </div>

        <div v-if="userFeedback?.messages">
            <ul v-for="message in userFeedback?.messages">
                <li>{{ message }}</li>
            </ul>
        </div>
    </div>
</template>