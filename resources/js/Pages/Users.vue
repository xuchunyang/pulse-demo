<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {User} from "@/types";
import {reactive} from "vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps<{
  users: User[];
}>();

const confirmingUserDeletion: Record<number, boolean>
    = reactive(props.users.map((user) => user.id).reduce((acc, id) => {
  acc[id] = false;
  return acc;
}, {} as Record<number, boolean>))

const closeConfirmingUserDeletionModal = (userId: number) => {
  confirmingUserDeletion[userId] = false;
};

const deleteUser = (userId: number) => {
  router.delete(route('users.destroy', userId), {
    onFinish: () => {
      closeConfirmingUserDeletionModal(userId);
    },
  });
};

const editingUser: Record<number, boolean>
    = reactive(props.users.map((user) => user.id).reduce((acc, id) => {
  acc[id] = false;
  return acc;
}, {} as Record<number, boolean>))

const login = (userId: number) => {
  router.post(route('impersonate', userId));
};
</script>

<template>
  <Head title="Dashboard"/>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">用户管理</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <table class="table-auto w-full border-collapse">
              <thead>
              <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">用户名</th>
                <th class="px-4 py-2">邮箱</th>
                <th class="px-4 py-2">创建时间</th>
                <th class="px-4 py-2">操作</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="user in users" :key="user.id">
                <td class="border px-4 py-2">{{ user.id }}</td>
                <td class="border px-4 py-2">{{ user.name }}</td>
                <td class="border px-4 py-2">{{ user.email }}</td>
                <td class="border px-4 py-2">{{ new Date(user.created_at).toISOString() }}</td>
                <td class="border px-4 py-2">
                  <div class="space-x-2">
                    <SecondaryButton @click="login(user.id)">登录</SecondaryButton>
                    <SecondaryButton
                        @click="editingUser[user.id] = true">
                      编辑
                    </SecondaryButton>
                    <Modal v-if="editingUser[user.id]" :show="editingUser[user.id]"
                           @close="editingUser[user.id] = false">
                      <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                          没空实现！
                        </h2>

                        <div class="mt-2 whitespace-pre text-sm bg-gray-50 p-2">{{ user }}</div>

                        <div class="mt-6 flex justify-end">
                          <SecondaryButton @click="editingUser[user.id] = false"> 取消</SecondaryButton>
                        </div>
                      </div>
                    </Modal>
                    <DangerButton
                        @click="confirmingUserDeletion[user.id] = true"
                    >
                      删除
                    </DangerButton>
                    <Modal v-if="confirmingUserDeletion[user.id]" :show="confirmingUserDeletion[user.id]"
                           @close="closeConfirmingUserDeletionModal(user.id)">
                      <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                          你确认要删除这个用户吗？
                        </h2>

                        <div class="mt-2 whitespace-pre text-sm bg-gray-50 p-2">{{ user }}</div>

                        <div class="mt-6 flex justify-end">
                          <SecondaryButton @click="closeConfirmingUserDeletionModal(user.id)"> 取消</SecondaryButton>

                          <DangerButton
                              class="ms-3"
                              @click="deleteUser(user.id)"
                          >
                            删除用户
                          </DangerButton>
                        </div>
                      </div>
                    </Modal>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
