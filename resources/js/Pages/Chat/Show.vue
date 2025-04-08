<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    name: "Show",
    components: {AuthenticatedLayout},

    props:['chats', 'user'],

    data() {
        return {
            message: null,
            localChats: [...this.chats]
        }
    },

    created() {
        window.Echo.private(`chat.${this.user.id}.${this.$page.props.auth.user.id}`)

            .listen('.chat-stored', res => {
                this.localChats.unshift(res.chat)
            })
    },

    methods: {
        store() {
            axios.post(`/chats`, {
                message: this.message,
                toUserId: this.user.id
            })
                .then(res => {
                    this.localChats.unshift(res.data)
                })
        }
    }
}

</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-100 py-6 px-4">
            <div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
                <h1 class="text-2xl font-bold mb-4">Chat {{ user.name }}</h1>

                <!-- Поле ввода -->
                <div class="mb-4">
                    <input
                        class="rounded-full border border-gray-400 w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"
                        v-model="message"
                        type="text"
                        placeholder="Your message"
                        @keyup.enter="store"
                    />
                </div>

                <!-- Кнопка отправки -->
                <div class="mb-6">
                    <button
                        @click="store"
                        class="rounded-lg w-full bg-sky-500 hover:bg-sky-600 text-white py-2 transition"
                    >
                        Отправить
                    </button>
                </div>

                <!-- Список сообщений -->
                <div v-if="localChats.length > 0">
                    <h3 class="text-xl font-semibold mb-4">Messages</h3>
                    <table class="w-full table-auto border border-gray-300 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Отправитель</th>
                            <th class="px-4 py-2 border">Сообщение</th>
                            <th class="px-4 py-2 border">Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="chat in localChats" :key="chat.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-4 py-2 border text-center">{{ chat.initiator }}</td>
                            <td class="px-4 py-2 border">{{ chat.message }}</td>
                            <td class="px-4 py-2 border text-right">{{ chat.time }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
