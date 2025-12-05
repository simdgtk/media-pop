<template>
    <div class="login-container">
        <form class="login-form" @submit.prevent="submitLogin">
            <h2 class="login-title">CONNEXION</h2>
            <div class="input-group">
                <label for="email">nom d’utilisateur</label>
                <input id="email" v-model="form.email" type="email" autocomplete="username" required />
            </div>
            <div class="input-group">
                <label for="password">
                    mot de passe
                    <span class="forgot" @click="goToForgot">mot de passe oublié ?</span>
                </label>
                <input id="password" v-model="form.password" type="password" autocomplete="current-password" required />
            </div>
            <button class="login-btn" type="submit">Connexion</button>
            <div v-if="error" class="error-msg">{{ error }}</div>
            <div class="register-link">
                Pas encore de compte ?
                <a href="/register">S’inscrire</a>
            </div>
            <div class="bg">
                <svg viewBox="0 0 310 206" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 80.474C0 41.7213 30.8798 12 75.6663 12C120.453 12 152 41.7041 152 80.474C152 119.244 121.806 147.334 75.6663 147.334C33.6034 147.334 0 120.858 0 80.474ZM3.39101 157.018H148.591V205.455H3.39101V157.018ZM93.9741 79.8215C93.9741 69.8114 85.1539 62.3768 75.6483 62.3768C66.8281 62.3768 58.0078 69.8114 58.0078 79.8215C58.0078 89.8317 66.8281 97.2663 75.6483 97.2663C85.1539 97.2663 93.9741 89.5226 93.9741 79.8215Z"
                        fill="currentColor" />
                    <path
                        d="M309.143 124.975C309.5 163.726 278.895 193.73 234.11 194.143C189.326 194.555 157.506 165.142 157.15 126.374C156.793 87.6059 186.727 59.239 232.865 58.8144C274.926 58.4273 308.772 84.593 309.143 124.975ZM305.048 48.4657L159.854 49.8021L159.408 1.36751L304.602 0.0311677L305.048 48.4657ZM215.179 126.493C215.271 136.502 224.159 143.855 233.665 143.768C242.485 143.687 251.236 136.171 251.144 126.161C251.052 116.152 242.163 108.799 233.344 108.88C223.838 108.967 215.09 116.792 215.179 126.493Z"
                        fill="currentColor" />
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
    justify-content: center;
    align-items: center;
    min-height: toRem(700);
    .login-form {
        max-width: toRem(700);
        width: 100%;
        padding: 0 toRem(24);
    }
}
.login-title {
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
  .forgot {
    color: $light-blue;
    font-size: toRem(15);
    font-weight: 400;
    margin-left: toRem(16);
    cursor: pointer;
    text-decoration: underline;
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
.login-btn {
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
.register-link {
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
.bg {
    opacity: 0.1;
}
.error-msg {
  color: red;
  text-align: center;
  margin-bottom: toRem(16);
  font-size: toRem(17);
}
</style>
