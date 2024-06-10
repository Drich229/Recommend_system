<template>
    <div>
      <form @submit.prevent="submitForm">
        <div>
          <label for="name">{{ $t('Name') }}</label>
          <input id="name" v-model="form.name" type="text" required autofocus autocomplete="name" />
          <p v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</p>
        </div>
  
        <div class="mt-4">
          <label for="email">{{ $t('Email') }}</label>
          <input id="email" v-model="form.email" type="email" required autocomplete="username" />
          <p v-if="errors.email" class="text-red-500">{{ errors.email[0] }}</p>
        </div>
  
        <div class="mt-4">
          <label for="password">{{ $t('Password') }}</label>
          <input id="password" v-model="form.password" type="password" required autocomplete="new-password" />
          <p v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</p>
        </div>
  
        <div class="mt-4">
          <label for="password_confirmation">{{ $t('Confirm Password') }}</label>
          <input id="password_confirmation" v-model="form.password_confirmation" type="password" required autocomplete="new-password" />
          <p v-if="errors.password_confirmation" class="text-red-500">{{ errors.password_confirmation[0] }}</p>
        </div>
  
        <div>
          <label for="role">{{ $t('Role') }}</label>
          <select id="role" v-model="form.role" required>
            <option value="user">{{ $t('User') }}</option>
            <option value="catalog_manager">{{ $t('Catalog Manager') }}</option>
          </select>
        </div>
  
        <div class="flex items-center justify-end mt-4">
          <a :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ $t('Already registered?') }}
          </a>
  
          <button type="submit" class="ml-4 bg-indigo-500 text-white px-4 py-2 rounded">
            {{ $t('Register') }}
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
          role: 'user'
        },
        errors: {}
      }
    },
    methods: {
      submitForm() {
        // Logique de soumission du formulaire
        // Vous pouvez utiliser axios ou fetch pour envoyer les données du formulaire au serveur
        // et gérer la réponse ici
      }
    }
  }
  </script>