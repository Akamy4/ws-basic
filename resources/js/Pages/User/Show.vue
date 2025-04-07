<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    name: "Show",
    components: {AuthenticatedLayout},

    props: [
        'user'
    ],

    data() {
        return {
            likeDetails: null,
        }
    },


    created() {
        window.Echo.channel(`like-stored-${this.$page.props.auth.user.id}`)
            .listen('.like-stored', res => {
                this.likeDetails = res.like
            })
    },


    methods: {
        sendLike() {
            console.log(`like-stored-${this.$page.props.auth.user.id}`)
            axios.post(`/users/${this.user.id}/like`)
                .then(res => {
                    this.likeDetails = res.data
                })
        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <Head><title>User Profile</title></Head>

        <div class="w-2/3 mx-auto py-6">
            <h1 class="text-2xl font-bold mb-4">User Profile</h1>

            <!-- Профиль пользователя и лайки -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-2">{{ user.name }}</h2>
                <p class="mb-2 text-gray-600">Email: {{ user.email }}</p>
                <p class="mb-4 text-gray-600">Likes: {{ likeDetails ? likeDetails.count : '' }}</p>

                <button
                    @click="sendLike"
                    class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded transition"
                >
                    ❤️ Like
                </button>

                <!-- Отображение информации о лайке -->
                <div v-if="likeDetails" class="mt-4 p-4 bg-gray-100 rounded-lg">
                    <p><strong>From:</strong> {{ likeDetails.fromUser.email }}</p>
                    <p><strong>To:</strong> {{ likeDetails.toUser.email }}</p>
                    <p><strong>Likes:</strong> {{ likeDetails.count }}</p>
                    <p><strong>Time:</strong> {{ likeDetails.time }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
