<script setup lang="ts">
import axios from "axios";
import {onMounted, ref} from "vue";
import FormComponent from "../../components/Forms/FormComponent.vue";
import PreloaderComponent from "../../components/Forms/PreloaderComponent.vue";

const props = defineProps({
    form_url: String,
    store_url: String,
    back_url: String,
    delete_url: {
        type: String,
        default: null
    }
})

const loading = ref(true);
const form = ref<object>();
const errors = ref<object>();

onMounted(async () => {
    loading.value = true
    await axios.post(props.form_url).then((response) => {
        form.value = response.data
        loading.value = false
    })
})

async function store() {
    errors.value = null;
    loading.value = true
    await axios.post(props.store_url, form.value/*, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }*/).then((response) => {
        if (response.data.success) {
            window.location.href = props.back_url
        }
    }).catch((e) => {
        if (e.response.status === 422) {
            errors.value = e.response.data.errors
        } else {
            throw e;
        }
    });
}

async function remove() {
    if (confirm('Вы уверены, что хотите удалить пользователя?')) {
        await axios.post(props.delete_url, form.value.id).then((response) => {
            if (response.data.success) {
                window.location.href = props.back_url
            }
        }).catch((e) => {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            } else {
                throw e;
            }
        })
    }
}
</script>

<template>
    <preloader-component v-if="loading"></preloader-component>

    <div v-if="!loading" class="row">
        <div class="controls col-12">
            <button v-if="delete_url" @click="remove()" class="btn btn-danger">Удалить</button>
        </div>

        <div class="col-12 col-md-6">
            <form-component :errors="errors" v-model="form"></form-component>

            <div class="row">
                <div class="col-6 col-sm-3">
                    <button class="btn btn-primary btn-block" @click="store()">Сохранить</button>
                </div>
                <div class="col-6 col-sm-3">
                    <a class="btn btn-secondary btn-block" :href="back_url">Назад</a>
                </div>
            </div>
        </div>
    </div>

</template>
