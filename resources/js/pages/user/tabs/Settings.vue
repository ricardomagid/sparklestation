<template>
  <div class="flex items-center justify-center min-h-full py-8">
    <div
      class="w-full max-w-3xl bg-red-950/40 backdrop-blur-sm border border-red-800/30 rounded-xl p-8 shadow-2xl shadow-black/50">
      <h2 class="text-3xl font-bold text-red-50 mb-8">Account Settings</h2>

      <div class="flex gap-10">
        <div class="flex flex-col items-center gap-4">
          <div class="relative group">
            <div
              class="w-44 h-44 rounded-full overflow-hidden border-4 border-red-700/50 bg-red-950/30 shadow-lg shadow-red-900/30">
              <img :src="profilePicture" alt="Profile Picture" class="w-full h-full object-cover user-picture" />
            </div>
            <div
              class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100"
              @click="$refs.fileInput.click()">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15.232 5.232l3.536 3.536M4 20h4.586a1 1 0 00.707-.293l9.414-9.414a1 1 0 000-1.414l-4.586-4.586a1 1 0 00-1.414 0L4 14.586V20z" />
              </svg>
            </div>
          </div>
          <input type="file" ref="fileInput" @change="handleFileChange" accept="image/*" class="hidden" />
          <button @click="$refs.fileInput.click()"
            class="px-6 py-2.5 bg-red-800 hover:bg-red-700 text-white rounded-lg font-medium transition-all hover:shadow-lg hover:shadow-red-900/40">
            Upload New Photo
          </button>
          <p class="text-xs text-red-200/50 text-center">Max 2MB • JPG, PNG, WEBP</p>
        </div>

        <div class="flex-1 space-y-6">
          <div>
            <label class="block text-red-100 font-semibold mb-2.5 text-sm uppercase tracking-wide" for="name">Name</label>
            <input id="name" v-model="name" type="text" placeholder="Enter your name" autocomplete="name"
              class="w-full bg-red-950/30 border border-red-800/40 rounded-lg px-4 py-3.5 text-red-50 placeholder-red-300/30 focus:outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/30 focus:bg-red-950/40 transition-all" />
          </div>

          <div>
            <label class="block text-red-100 font-semibold mb-2.5 text-sm uppercase tracking-wide" for="email">Email</label>
            <input id="email" v-model="email" type="email" placeholder="Enter your email" autocomplete="email"
              class="w-full bg-red-950/30 border border-red-800/40 rounded-lg px-4 py-3.5 text-red-50 placeholder-red-300/30 focus:outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/30 focus:bg-red-950/40 transition-all" />
          </div>

          <div class="flex gap-3">
            <button @click="goToChangePassword"
              class="flex-0 bg-red-800 hover:bg-red-700 text-white font-semibold px-4 py-2.5 rounded-lg transition-all shadow-sm hover:shadow-md hover:scale-[1.02]">
              Change Password
            </button>
          </div>

          <div class="pt-6 flex gap-3">
            <button @click="saveChanges"
              class="flex-1 bg-red-800 hover:bg-red-700 text-white font-bold py-3.5 rounded-lg transition-all shadow-lg shadow-red-900/40 hover:shadow-red-900/60 hover:scale-[1.02]">
              Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const userData = JSON.parse(document.getElementById('userApp').dataset.user);

export default {
  data() {
    return {
      name: userData.username,
      email: userData.email,
      profilePicture: userData.img,
      isDirty: false
    }
  },
  watch: {
    name() { this.isDirty = true },
    email() { this.isDirty = true }
  },
  methods: {
    goToChangePassword() {
      if (this.isDirty) {
        const discard = confirm("Your changes will be discarded. Continue?");
        if (!discard) return;
      }
      window.location.href = '/login?panel=changepassword';
    },
    handleFileChange(event) {
      window.previewAndUpload(event.target)
    },
    saveChanges() {
      fetch('/api/profile/update', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username: this.name, email: this.email })
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            newNotification("success", "Profile updated successfully.");
            this.isDirty = false;
            document.querySelectorAll(".user-username").forEach(username => username.textContent = this.name);
          } else {
            newNotification("error", `Update failed: ${data.message || 'Unknown error'}`);
          }
        })
        .catch(err => {
          newNotification("error", `Update error: ${err}`);
        });
    },
    beforeRouteLeave(to, from, next) {
      if (this.isDirty) {
        if (confirm("Your changes will be discarded. Continue?")) {
          next()
        } else {
          next(false)
        }
      } else {
        next()
      }
    }
  }
}
</script>