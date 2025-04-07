<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'

const props = defineProps({
    messages: Array
})

const body = ref('')
const messages = ref([...props.messages])

const store = () => {
    axios.post('/messages', { body: body.value }).then(res => {
        messages.value.unshift(res.data)
        body.value = ''
    })
}

onMounted(() => {
    window.Echo.channel('message-stored')
        .listen('.message-stored', res => {
            messages.value.unshift(res.message)
        })
})
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Messages" />

        <div class="w-2/3 mx-auto py-6">
            <!-- Ввод нового сообщения -->
            <div>
                <div class="mb-4">
                    <input
                        class="rounded-full border border-gray-400 w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"
                        v-model="body"
                        type="text"
                        placeholder="Your message"
                        @keyup.enter="store"
                    />
                </div>
                <div class="mb-4">
                    <button
                        @click="store"
                        class="rounded-lg w-full bg-sky-500 hover:bg-sky-600 text-white py-2 transition"
                    >
                        Send
                    </button>
                </div>
            </div>

            <!-- Таблица сообщений -->
            <div v-if="messages.length > 0" class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Messages</h3>
                <table class="w-full table-auto border border-gray-300 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Message</th>
                        <th class="px-4 py-2 border">Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="message in messages"
                        :key="message.id"
                        class="hover:bg-gray-50"
                    >
                        <td class="px-4 py-2 border text-center">{{ message.id }}</td>
                        <td class="px-4 py-2 border">{{ message.body }}</td>
                        <td class="px-4 py-2 border text-right">{{ message.time }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
