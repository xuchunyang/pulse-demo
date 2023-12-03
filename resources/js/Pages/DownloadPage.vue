<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import axios from "axios";
import { reactive, ref } from "vue";

interface SEO {
    title: string;
    description: string;
    keywords: string;
    icon: string;
}

const seo: SEO = reactive({
    title: "",
    description: "",
    keywords: "",
    icon: "",
});

const isDone = ref<boolean>(false);

const form = useForm({
    url: "",
});

const submit = async () => {
    const resp = await axios.get(route("seo"), {
        params: {
            url: form.url,
        },
    });
    seo.title = resp.data.title;
    seo.description = resp.data.description;
    seo.keywords = resp.data.keywords;
    seo.icon = resp.data.icon;

    isDone.value = true;
};
</script>

<template>
    <div>
        <form @submit.prevent="submit">
            <h1 class="text-xl font-medium mb-4">抓取网站 SEO</h1>
            <div>
                <InputLabel for="url" value="网址" />
                <TextInput
                    class="w-full mt-1"
                    id="url"
                    v-model="form.url"
                    type="url"
                    required
                    placeholder="输入网站"
                    list="example-urls"
                    :disabled="form.processing"
                />
                <datalist id="example-urls">
                    <option value="https://www.laravel.com/" />
                    <option value="https://pulse.laravel.com/" />
                    <option value="https://learnku.com/laravel" />
                    <option value="https://sspai.com/" />
                    <option value="https://www.thepaper.cn//" />
                </datalist>
                <InputError class="mt-2" :message="form.errors.url" />
            </div>
        </form>
        <div v-if="form.processing">
            <div class="mt-4">
                <svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0
          3.042 1.135 5.824 3 7.938l3-2.647z"
                    ></path>
                </svg>
                <span>正在抓取...</span>
            </div>
        </div>
        <table v-if="isDone" class="table-auto w-full mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">标题</th>
                    <th class="px-4 py-2">描述</th>
                    <th class="px-4 py-2">关键词</th>
                    <th class="px-4 py-2">图标</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">{{ seo.title }}</td>
                    <td class="border px-4 py-2">{{ seo.description }}</td>
                    <td class="border px-4 py-2">{{ seo.keywords }}</td>
                    <td class="border px-4 py-2">
                        <img v-if="seo.icon" :src="seo.icon" alt="icon" />
                        <span v-else>没有找到图标</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
