<template>
  <div class="register-container">
    <form class="register-form" @submit.prevent="submitRegister">
      <h2 class="register-title">INSCRIPTION</h2>
      <div class="input-group">
        <label for="name">Nom</label>
        <input id="name" v-model="form.name" type="text" required autocomplete="name" />
      </div>
      <div class="input-group">
        <label for="email">Email</label>
        <input id="email" v-model="form.email" type="email" required autocomplete="username" />
      </div>
      <div class="input-group">
        <label for="password">Mot de passe</label>
        <input id="password" v-model="form.password" type="password" required autocomplete="new-password" />
      </div>
      <div class="input-group">
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input id="password_confirmation" v-model="form.password_confirmation" type="password" required autocomplete="new-password" />
      </div>
      <button class="register-btn" type="submit">S'inscrire</button>
      <div v-if="error" class="error-msg">{{ error }}</div>
      <div class="login-link">
        Déjà inscrit ?
        <a href="/login">Se connecter</a>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});
const error = ref('');

const submitRegister = async () => {
  error.value = '';
  try {
    const res = await fetch('/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify(form.value),
      credentials: 'same-origin'
    });
    if (res.ok) {
      window.location.href = '/';
    } else {
      const data = await res.json();
      if (data.errors) {
        error.value = Object.values(data.errors).flat().join(' ');
      } else {
        error.value = data.message || 'Erreur lors de l’inscription';
      }
    }
  } catch (e) {
    error.value = 'Erreur réseau';
  }
};
</script>

<style scoped lang="scss">
.register-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: toRem(700);
  .register-form {
    max-width: toRem(700);
    width: 100%;
    padding: 0 toRem(24);
  }
}
.register-title {
  color: $blue;
  font-size: toRem(35);
  font-weight: 900;
  margin-bottom: toRem(40);
  letter-spacing: 0.01em;
}
.input-group {
  display: flex;
  flex-direction: column;
  margin-bottom: toRem(24);
  label {
    color: $blue;
    font-weight: 700;
    font-size: toRem(18);
    margin-bottom: toRem(8);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  input {
    border: 2px solid $blue;
    border-radius: 1rem;
    padding: toRem(14) toRem(19);
    font-size: toRem(18);
    outline: none;
    margin-top: toRem(3);
    transition: border-color 0.2s;
    &:focus {
      border-color: $light-blue;
    }
  }
}
.register-btn {
  background: $blue;
  color: $white;
  border: none;
  border-radius: 1rem;
  padding: toRem(12) toRem(24);
  font-size: toRem(19);
  font-weight: 600;
  width: 100%;
  margin-bottom: toRem(19);
  cursor: pointer;
  transition: background 0.2s;
  &:hover {
    background: #3700b3;
  }
}
.login-link {
  text-align: center;
  color: $blue;
  font-size: toRem(17);
  margin-bottom: toRem(24);
  a {
    color: $blue;
    text-decoration: underline;
    font-style: italic;
    margin-left: toRem(3);
  }
}
.error-msg {
  color: red;
  text-align: center;
  margin-bottom: toRem(16);
  font-size: toRem(17);
}
</style>
