<template>
  <div>
    <div class="mb-8 flex justify-start max-w-3xl">
      <h1 class="font-bold text-3xl">
        <inertia-link class="text-green-400 hover:text-green-600" :href="route('users')">Users</inertia-link>
        <span class="text-green-400 font-medium">/</span>
        {{ form.first_name }} {{ form.last_name }}
      </h1>
      <img v-if="user.photo" class="block w-8 h-8 rounded-full ml-4" :src="user.photo" />
    </div>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.first_name" :error="form.errors.first_name" class="pr-6 pb-8 w-full lg:w-1/2" label="First name" />
          <text-input v-model="form.last_name" :error="form.errors.last_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Last name" />
          <text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.password" :error="form.errors.password" class="pr-6 pb-8 w-full lg:w-1/2" type="password" autocomplete="new-password" label="Password" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Nomor HP" />
            <select-input v-model="form.role" :error="form.errors.role" v-if="$page.props.auth.user.role==1" class="pr-6 pb-8 w-full lg:w-1/2" label="Role User">
                <option value="1">Pemilik</option>
                <option value="2">Admin</option>
                <option value="3">Customer</option>
            </select-input>
            <select-input v-model="form.role" :error="form.errors.role" v-if="$page.props.auth.user.role==2" class="pr-6 pb-8 w-full lg:w-1/2" label="Role User">
                <option value="3" selected>Customer</option>
            </select-input>
          <file-input v-model="form.photo" :error="form.errors.photo" class="pr-6 pb-8 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <loading-button :loading="form.processing" class="btn-green ml-auto" type="submit">Update User</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import FileInput from '@/Shared/FileInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  metaInfo() {
    return {
      title: `${this.form.first_name} ${this.form.last_name}`,
    }
  },
  components: {
    FileInput,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    user: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        first_name: this.user.first_name,
        last_name: this.user.last_name,
        email: this.user.email,
        password: null,
        role: this.user.role,
        photo: null,
        phone: this.user.phone
      }),
    }
  },
  methods: {
    update() {
      this.form.post('/users/'+this.user.id, {
        onSuccess: () => this.form.reset('password', 'photo'),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this user?')) {
        this.$inertia.delete('/users/'+this.user.id)
      }
    },
  },
}
</script>
