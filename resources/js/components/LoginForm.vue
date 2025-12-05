<template>
  <div class="login-container">
    <form class="login-form" @submit.prevent="submitLogin">
      <h1 class="login-title">CONNEXION</h1>
      <div class="input-group">
        <label for="email">nom d’utilisateur</label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          autocomplete="username"
          required
        />
      </div>
      <div class="input-group">
        <label for="password">
          mot de passe
          <span class="forgot" @click="goToForgot">mot de passe oublié ?</span>
        </label>
        <input
          id="password"
          v-model="form.password"
          type="password"
          autocomplete="current-password"
          required
        />
      </div>
      <button class="login-btn" type="submit">Connexion</button>
      <div v-if="error" class="error-msg">{{ error }}</div>
      <div class="register-link">
        Pas encore de compte ?
        <a href="/register">S’inscrire</a>
      </div>
      <div class="login-bg">
        <svg width="300" height="120" viewBox="0 0 300 120" fill="none">
          <circle cx="60" cy="60" r="50" fill="#E6E6FF" />
          <circle cx="220" cy="80" r="50" fill="#E6E6FF" />
          <rect x="20" y="100" width="80" height="30" fill="#E6E6FF" />
          <rect x="180" y="20" width="100" height="40" fill="#E6E6FF" />
        </svg>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const form = ref({ email: '', password: '' });
const error = ref('');

const submitLogin = async () => {
  error.value = '';
  try {
    const res = await fetch('/login', {
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
      error.value = data.message || 'Identifiants invalides';
    }
  } catch (e) {
    error.value = 'Erreur réseau';
  }
};

const goToForgot = () => {
  window.location.href = '/forgot-password';
};
</script>

<style scoped lang="scss">
.login-container {
  display: flex;
  align-items: center;
  justify-content: center;
}
.login-form {
  position: relative;
  display: flex;
  flex-direction: column;
}
.login-title {
  color: $blue;
  font-size: 2.2rem;
  font-weight: 900;
  margin-bottom: 2.5rem;
  letter-spacing: 0.01em;
}
.input-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 1.5rem;
  label {
    color: $blue;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .forgot {
    color: $light-blue;
    font-size: 0.95rem;
    font-weight: 400;
    margin-left: 1rem;
    cursor: pointer;
    text-decoration: underline;
  }
  input {
    border: 2px solid $blue;
    border-radius: 1rem;
    padding: 0.9rem 1.2rem;
    font-size: 1.1rem;
    outline: none;
    margin-top: 0.2rem;
    transition: border-color 0.2s;
    &:focus {
      border-color: $light-blue;
    }
  }
}
.login-btn {
  background: $blue;
  color: #fff;
  border: none;
  border-radius: 1rem;
  padding: 1rem 0;
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 1.2rem;
  cursor: pointer;
  transition: background 0.2s;
  &:hover {
    background: #3700b3;
  }
}
.register-link {
  text-align: center;
  color: $blue;
  font-size: 1.05rem;
  margin-bottom: 1.5rem;
  a {
    color: $blue;
    text-decoration: underline;
    font-style: italic;
    margin-left: 0.2rem;
  }
}
.error-msg {
  color: #FD494A;
  text-align: center;
  margin-bottom: 1rem;
  font-size: 1.05rem;
}
.login-bg {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  z-index: 0;
  pointer-events: none;
  svg {
    width: 100%;
    height: auto;
    display: block;
  }
}
</style>
