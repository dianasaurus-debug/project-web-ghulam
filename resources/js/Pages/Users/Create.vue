<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-green-400 hover:text-green-600" :href="route('users')">Users</inertia-link>
      <span class="text-green-400 font-medium">/</span> Buat
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
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
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-green" type="submit">Buat User</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import FileInput from '@/Shared/FileInput'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  metaInfo: { title: 'Buat User' },
  components: {
    FileInput,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        role: false,
        photo: null,
        phone : null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/users');
    },
  },
}
</script>
