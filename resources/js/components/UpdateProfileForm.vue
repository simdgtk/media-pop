<template>
  <section class="profile">
    <div class="profile-header">
      <img :src="userImage" alt="avatar" class="avatar" />
      <div class="role-and-desc">
        <div class="role">ADMINISTRATEUR</div>
        <div class="desc">"J'écris des articles cools"</div>
      </div>
    </div>
    <div class="profile-content">

        <button class="add-article" @click="$emit('add-article')">ajouter un article</button>
        <button class="logout" @click="logout">déconnexion</button>

        <form ref="logoutForm" method="POST" action="/logout" style="display: none;">
          <input type="hidden" name="_token" :value="csrfToken" />
        </form>

        <h3>INFORMATIONS DE PROFIL</h3>
        <form @submit.prevent="submitProfile">
          <div class="input-group">
            <input v-model="form.name" type="text" placeholder="Nom" />
            <button type="button" class="edit-btn"><svg width="16" height="16" fill="currentColor"><path d="M12.146 2.854a.5.5 0 0 1 .708 0l.292.292a.5.5 0 0 1 0 .708l-8.5 8.5a.5.5 0 0 1-.168.11l-3 1a.5.5 0 0 1-.637-.637l1-3a.5.5 0 0 1 .11-.168l8.5-8.5zM11.207 3.5 3 11.707V13h1.293L12.5 4.793 11.207 3.5z"/></svg></button>
          </div>
          <div class="input-group">
            <input v-model="form.email" type="email" placeholder="Email" />
            <button type="button" class="edit-btn"><svg width="16" height="16" fill="currentColor"><path d="M12.146 2.854a.5.5 0 0 1 .708 0l.292.292a.5.5 0 0 1 0 .708l-8.5 8.5a.5.5 0 0 1-.168.11l-3 1a.5.5 0 0 1-.637-.637l1-3a.5.5 0 0 1 .11-.168l8.5-8.5zM11.207 3.5 3 11.707V13h1.293L12.5 4.793 11.207 3.5z"/></svg></button>
          </div>
          <button type="submit" class="save-btn">enregistrer</button>
          <div v-if="success" class="success-msg">Enregistré.</div>
          <div v-if="error" class="error-msg">{{ error }}</div>
        </form>

        <h3>MODIFICATION DE MOT DE PASSE</h3>
        <form @submit.prevent="submitPassword">
          <input v-model="passwordForm.current" type="password" placeholder="Mot de passe actuel" />
          <input v-model="passwordForm.new" type="password" placeholder="Nouveau mot de passe" />
          <input v-model="passwordForm.confirm" type="password" placeholder="Confirmation du mot de passe" />
          <button type="submit" class="save-btn">enregistrer</button>
          <div v-if="passwordSuccess" class="success-msg">Mot de passe modifié.</div>
          <div v-if="passwordError" class="error-msg">{{ passwordError }}</div>
        </form>

        <h3>SUPPRESSION DE COMPTE</h3>
        <p>Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.</p>
        <form @submit.prevent="deleteAccount">
          <input v-model="deletePassword" type="password" placeholder="Mot de passe" />
          <button type="submit" class="delete-btn">supprimer</button>
          <div v-if="deleteError" class="error-msg">{{ deleteError }}</div>
        </form>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

const props = defineProps<{
  user?: { name: string; email: string; image?: string };
}>();

const form = ref({ name: props.user?.name || '', email: props.user?.email || '' });
const passwordForm = ref({ current: '', new: '', confirm: '' });
const deletePassword = ref('');
const success = ref(false);
const error = ref('');
const passwordSuccess = ref(false);
const passwordError = ref('');
const deleteError = ref('');
const userImage = ref(props.user?.image || '/default-avatar.png');

const submitProfile = async () => {
  success.value = false;
  error.value = '';
  try {
    const res = await fetch('/profile', {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' },
      body: JSON.stringify(form.value),
    });
    if (res.ok) {
      success.value = true;
    } else {
      const data = await res.json();
      error.value = data.message || 'Erreur lors de la mise à jour';
    }
  } catch (e) {
    error.value = 'Erreur réseau';
  }
};

const submitPassword = async () => {
  passwordSuccess.value = false;
  passwordError.value = '';
  try {
    const res = await fetch('/user/password', {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' },
      body: JSON.stringify(passwordForm.value),
    });
    if (res.ok) {
      passwordSuccess.value = true;
      passwordForm.value = { current: '', new: '', confirm: '' };
    } else {
      const data = await res.json();
      passwordError.value = data.message || 'Erreur lors du changement de mot de passe';
    }
  } catch (e) {
    passwordError.value = 'Erreur réseau';
  }
};

const deleteAccount = async () => {
  deleteError.value = '';
  try {
    const res = await fetch('/profile', {
      method: 'DELETE',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' },
      body: JSON.stringify({ password: deletePassword.value }),
    });
    if (res.ok) {
      window.location.href = '/';
    } else {
      const data = await res.json();
      deleteError.value = data.message || 'Erreur lors de la suppression';
    }
  } catch (e) {
    deleteError.value = 'Erreur réseau';
  }
};

const logoutForm = ref<HTMLFormElement | null>(null);
const csrfToken = ref('');

onMounted(() => {
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  if (token) {
    csrfToken.value = token;
  }
  if (props.user) {
    form.value = { name: props.user.name, email: props.user.email };
    userImage.value = props.user.image || '/default-avatar.png';
  }
});

const logout = () => {
  if (logoutForm.value) {
    logoutForm.value.submit();
  }
};
</script>

<style scoped lang="scss">
.profile {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: $white;
    border-radius: toRem(24);
}
.profile-header {
  display: flex;
  width: 100%;
  align-items: center;
  background: $red;
  border-radius: 0 0 toRem(24) toRem(24);

  .avatar {
    width: toRem(80);
    height: toRem(80);
    border-radius: 50%;
    object-fit: cover;
    margin-right: toRem(16);
    background-color: beige;
  }

  .role-and-desc {
    display: flex;
    flex-direction: column;
    gap: toRem(12);

      .role {
        font-weight: 600;
        color: $white;
        font-size: toRem(16);
      }
      .desc {
        color: $white;
        font-size: toRem(14);
        font-style: italic;
        font-weight: 400;
      }
  }
}
.add-article {
  display: block;
  width: 100%;
  background: $blue;
  color: $white;
  font-size: 1.5rem;
  border: none;
  border-radius: 16px;
  padding: 18px 0;
  margin: 0 0 16px 0;
  cursor: pointer;
}

.profile-content {
    padding: toRem(24);
    max-width: toRem(700);
}
.logout {
  display: block;
  width: 100%;
  background: $white;
  color: $blue;
  font-size: 1.1rem;
  border: 2px solid $blue;
  border-radius: 16px;
  padding: 12px 0;
  margin-bottom: 32px;
  cursor: pointer;
}
h3 {
  color: $blue;
  font-size: 1.2rem;
  margin: 32px 0 12px 0;
  font-weight: bold;
  text-transform: uppercase;
}
.input-group {
  display: flex;
  align-items: center;
  margin-bottom: 16px;
  input {
    flex: 1;
    border: 1px solid #ccc;
    border-radius: 999px;
    font-size: 1rem;
    padding: 12px 16px;
    margin-right: 8px;
    outline: none;
    transition: border-color 0.2s;
    &:focus {
      border-color: $blue;
    }
  }
  .edit-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: $blue;
    padding: 4px;
    border-radius: 50%;
    transition: background 0.2s;
    &:hover {
      background: #f0f0ff;
    }
  }
}
.save-btn {
  background: $blue;
  color: $white;
  border: none;
  border-radius: 999px;
  padding: 12px 0;
  width: 100%;
  font-size: 1.1rem;
  margin-bottom: 12px;
  cursor: pointer;
}
.delete-btn {
  background: $white;
  color: $red;
  border: 2px solid $red;
  border-radius: 999px;
  padding: 12px 0;
  width: 100%;
  font-size: 1.1rem;
  margin-top: 8px;
  cursor: pointer;
}
.success-msg {
  color: $blue;
  font-size: 1rem;
  margin-top: 8px;
}
.error-msg {
  color: $red;
  font-size: 1rem;
  margin-top: 8px;
}
form input[type="password"] {
  border: toRem(1) solid $light-blue;
  border-radius: 999px;
  font-size: 1rem;
  padding: 12px 16px;
  margin-bottom: 12px;
  outline: none;
  transition: border-color 0.2s;
  width: 100%;
  &:focus {
    border-color: $blue;
  }
}
section {
  margin: 0 auto;
  background: $white;
}
p {
  color: $blue;
  font-size: 1rem;
  margin-bottom: 8px;
}
</style>
