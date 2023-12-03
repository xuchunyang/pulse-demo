<script setup lang="ts">
import {User} from "@/types";
import InputLabel from "@/Components/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps<{
    users: User[];
}>();

const form = useForm({
    user: props.users[0]?.id,
});

const submit = () => {
    form.post(route('impersonate', form.user), {
        onFinish: () => {
            form.reset('user');
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <div>
            <InputLabel for="user" value="选择用户"/>
            <select id="user"
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }} &lt;{{
                        user.email
                    }}&gt;
                </option>
            </select>
        </div>
        <div class="flex items-center justify-end mt-4">
            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                模拟登录
            </PrimaryButton>
        </div>
    </form>
</template>
