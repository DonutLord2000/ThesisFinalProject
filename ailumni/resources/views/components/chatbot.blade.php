<div x-data="chatbot()" class="fixed bottom-4 right-4 z-50" role="region" aria-label="AI-Lumni Chatbot">
  @auth
      <button @click="open = !open" class="bg-gray-800 text-white rounded-full p-3 shadow-lg hover:bg-gray-700 transition duration-300" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
          </svg>
          <span class="sr-only">AI-Lumni</span>
      </button>
      <div x-show="open" @click.away="open = false" class="absolute bottom-16 right-0 bg-gray-800 text-white rounded-lg shadow-xl border border-gray-700" style="width: 30rem" x-cloak>
          <div class="p-4 border-b border-gray-700">
              <h3 class="text-lg font-semibold text-white">AI-Lumni</h3>
          </div>
          <div x-ref="messageContainer" class="p-4" style="max-height: 300px; overflow-y: auto; overflow-x: hidden; width: 100%;">
              <template x-for="message in messages" :key="message.id">
                  <div class="mb-4 w-full" :class="{'text-right': message.role === 'user', 'text-left': message.role === 'assistant'}">
                      <span x-text="message.content" :class="{'mt-2 mr-2 ml-4 bg-gray-500 text-white p-2 rounded-lg inline-block': message.role === 'user', 'ml-2 mr-4 bg-gray-500 text-white p-2 rounded-lg inline-block': message.role === 'assistant'}"></span>
                  </div>
              </template>
              <div x-show="isLoading" class="text-left py-2">
                  <span class="ml-2 inline-block animate-pulse text-blue-400">AI-Lumni is thinking...</span>
              </div>
          </div>
          <div class="p-4 border-t border-gray-700">
              <form @submit.prevent="sendMessage()" class="flex space-x-2">
                  <input x-model="userInput" type="text" placeholder="Type your message..." class="flex-grow px-3 py-2 bg-gray-800 text-white border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" :disabled="isLoading" aria-label="Chat message input">
                  <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300" :disabled="isLoading">
                      <span x-show="!isLoading">Send</span>
                      <span x-show="isLoading" class="animate-pulse">Sending...</span>
                  </button>
              </form>
              <div x-show="errorMessage" class="text-red-500 mt-2 text-sm" x-text="errorMessage"></div>
          </div>
      </div>
  @else
      <button @click="alert('Please log in to use the chatbot.')" class="bg-gray-800 text-white rounded-full p-3 shadow-lg hover:bg-gray-700 transition duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
          </svg>
      </button>
  @endauth
</div>

<script>
  function chatbot() {
      return {
          open: false,
          messages: [],
          userInput: '',
          isLoading: false,
          errorMessage: '',
          sendMessage() {
              if (this.userInput.trim() === '') return;

              this.messages.push({ id: Date.now(), role: 'user', content: this.userInput });
              this.isLoading = true;
              this.errorMessage = '';

              fetch('/chatbot', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                  },
                  body: JSON.stringify({ message: this.userInput })
              })
                  .then(response => {
                      if (!response.ok) {
                          throw new Error('Network response was not ok');
                      }
                      return response.json();
                  })
                  .then(data => {
                      if (data.reply) {
                          this.messages.push({ id: Date.now(), role: 'assistant', content: data.reply });
                      } else {
                          this.errorMessage = 'Unexpected response from the server.';
                      }
                      this.isLoading = false;
                      this.scrollToBottom();
                  })
                  .catch(error => {
                      console.error('Error:', error);
                      this.errorMessage = 'Failed to get a response from the server. Please try again.';
                      this.isLoading = false;
                  });

              this.userInput = '';
              this.scrollToBottom();
          },
          scrollToBottom() {
              this.$nextTick(() => {
                  const messageContainer = this.$refs.messageContainer;
                  messageContainer.scrollTop = messageContainer.scrollHeight;
              });
          }
      }
  }
</script>
