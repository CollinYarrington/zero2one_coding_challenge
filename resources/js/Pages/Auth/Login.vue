<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import InputText from '@/Components/Ui/Input/InputText.vue';
import InputError from '@/Components/Ui/Input/InputError.vue';
import Label from '@/Components/Ui/Label/Label.vue';
import { useForm } from "@inertiajs/vue3";
defineProps({ message: String });

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('auth.store'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AppLayout>
        <div class="bg-white border rounded absolute right-1/2 translate-x-1/2 bottom-1/2 translate-y-1/2 w-full sm:w-80">
            <h1 class="text-center text-3xl my-5">Login Screen</h1>
            <form @submit.prevent="submit" novalidate class="p-5">
                <div class="grid gap-2">
                    <Label for="email" required>Email address</Label>
                    <InputText
                        id="email"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@example.com"
                        :error="form.errors.email"
                    />
                    <InputError :message="form.errors.email" />
                </div>
                <div class="grid gap-2">
                    <Label for="password" required>Password</Label>
                    <InputText
                        id="password"
                        type="password"
                        required
                        autofocus
                        v-model="form.password"
                        :error="form.errors.password"
                    />
                    <InputError :message="form.errors.password" />
                </div>
                <div class="grid gap-2 pt-5">
                <button class="border rounded p-2 hover:scale-105">Login</button>
                </div>
            </form>
        </div>
    </AppLayout>

</template>