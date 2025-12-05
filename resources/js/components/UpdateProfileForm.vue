<template>
    <section class="profile">
        <div class="profile-header">
            <img :src="userImage" alt="avatar" class="avatar" />
            <div class="role-and-desc">
                <div class="role">{{ form.name }}</div>
                <div class="desc">{{ form.email }}</div>
            </div>
        </div>
        <div class="profile-content">

            <a class="add-article" href="/article/create">
                <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M35 20C35 20.3315 34.8683 20.6495 34.6339 20.8839C34.3995 21.1183 34.0815 21.25 33.75 21.25H21.25V33.75C21.25 34.0815 21.1183 34.3995 20.8839 34.6339C20.6495 34.8683 20.3315 35 20 35C19.6685 35 19.3505 34.8683 19.1161 34.6339C18.8817 34.3995 18.75 34.0815 18.75 33.75V21.25H6.25C5.91848 21.25 5.60054 21.1183 5.36612 20.8839C5.1317 20.6495 5 20.3315 5 20C5 19.6685 5.1317 19.3505 5.36612 19.1161C5.60054 18.8817 5.91848 18.75 6.25 18.75H18.75V6.25C18.75 5.91848 18.8817 5.60054 19.1161 5.36612C19.3505 5.1317 19.6685 5 20 5C20.3315 5 20.6495 5.1317 20.8839 5.36612C21.1183 5.60054 21.25 5.91848 21.25 6.25V18.75h23.75C34.0815 18.75 34.3995 18.8817 34.6339 19.1161C34.8683 19.3505 35 19.6685 35 20Z"
                        fill="currentColor" />
                </svg>
                ajouter un article
            </a>
            <button class="logout" @click="logout">déconnexion</button>

            <h2>INFORMATIONS DE PROFIL</h2>
            <form @submit.prevent="submitProfile">
                <div class="input-group">
                    <input v-model="form.name" type="text" placeholder="Nom" />
                </div>
                <div class="input-group">
                    <input v-model="form.email" type="email" placeholder="Email" />
                </div>
                <button type="submit" class="save-btn">enregistrer</button>
                <div v-if="success" class="success-msg">Enregistré.</div>
                <div v-if="error" class="error-msg">{{ error }}</div>
            </form>

            <h2>MODIFICATION DE MOT DE PASSE</h2>
            <form @submit.prevent="submitPassword">
                <input v-model="passwordForm.current" type="password" placeholder="Mot de passe actuel" />
                <input v-model="passwordForm.new" type="password" placeholder="Nouveau mot de passe" />
                <input v-model="passwordForm.confirm" type="password" placeholder="Confirmation du mot de passe" />
                <button type="submit" class="save-btn">enregistrer</button>
                <div v-if="passwordSuccess" class="success-msg">Mot de passe modifié.</div>
                <div v-if="passwordError" class="error-msg">{{ passwordError }}</div>
            </form>

            <h2>SUPPRESSION DE COMPTE</h2>
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
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
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
        const res = await fetch('/password', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                current_password: passwordForm.value.current,
                password: passwordForm.value.new,
                password_confirmation: passwordForm.value.confirm,
            }),
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
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
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

onMounted(() => {
    if (props.user) {
        form.value = { name: props.user.name, email: props.user.email };
        userImage.value = props.user.image || '/default-avatar.png';
    }
});

const logout = async () => {
    try {
        const res = await fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
        });
        if (res.ok) {
            window.location.href = '/';
        }
    } catch (e) {
        console.error('Erreur de déconnexion', e);
        window.location.href = '/';
    }
};
</script>

<style scoped lang="scss">
.profile {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: $white;
    color: $black;
}

.profile-header {
    display: flex;
    width: 100%;
    align-items: center;
    background: $red;
    border-radius: 0 0 toRem(24) toRem(24);
    padding: toRem(24);
    padding-top: toRem(42);

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
    background: $blue;
    color: $white;
    font-size: toRem(18);
    border: none;
    border-radius: toRem(16);
    padding: toRem(24);
    margin: 0 0 16px 0;
    cursor: pointer;
    margin: 0 auto;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-bottom: toRem(32);
    width: fit-content;

    svg {
        width: toRem(40);
        height: toRem(40);
        margin-right: toRem(8);
        vertical-align: middle;
    }
}

.profile-content {
    padding: toRem(24);
    max-width: toRem(700);
}

h2 {
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

.save-btn,
.logout,
.delete-btn {
    background: $blue;
    color: $white;
    border: none;
    border-radius: 999px;
    padding: toRem(12) toRem(24);
    width: fit-content;
    font-size: 1.1rem;
    margin-bottom: 12px;
    cursor: pointer;
}

.delete-btn {
    background: $red;
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
