<div x-data="chatbot()" class="fixed bottom-4 right-4 z-50">
    <!-- Chat Icon -->
    <button @click="open = !open" class="bg-blue-500 text-white rounded-full p-3 shadow-lg hover:bg-blue-600 transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
    </button>

    <!-- Chat Window -->
    <div x-show="open" @click.away="open = false" class="absolute bottom-16 right-0 w-80 bg-white rounded-lg shadow-xl border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Chatbot</h3>
        </div>
        <div class="h-80 overflow-y-auto p-4 space-y-4">
            <template x-for="message in messages" :key="message.id">
                <div :class="{'text-right': message.role === 'user'}">
                    <span x-text="message.content" :class="{'bg-blue-100 p-2 rounded-lg inline-block': message.role === 'user', 'bg-gray-100 p-2 rounded-lg inline-block': message.role === 'assistant'}"></span>
                </div>
            </template>
        </div>
        <div class="p-4 border-t border-gray-200">
            <form @submit.prevent="sendMessage">
                <div class="flex space-x-2">
                    <input x-model="userInput" type="text" placeholder="Type your message..." class="flex-grow px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function chatbot() {
    return {
        open: false,
        messages: [],
        userInput: '',
        sendMessage() {
            if (this.userInput.trim() === '') return;

            this.messages.push({ id: Date.now(), role: 'user', content: this.userInput });
            
            fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: this.userInput })
            })
            .then(response => response.json())
            .then(data => {
                this.messages.push({ id: Date.now(), role: 'assistant', content: data.reply });
            })
            .catch(error => console.error('Error:', error));

            this.userInput = '';
        }
    }
}
</script>