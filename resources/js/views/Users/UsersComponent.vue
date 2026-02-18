<script setup lang="ts">
import axios from "axios";
import FormComponent from "../../components/Forms/FormComponent.vue";
import {onMounted, ref} from "vue";
import PreloaderComponent from "../../components/Forms/PreloaderConponent.vue";

const props = defineProps<{
    form_url: string,
    back_url: string
}>()

const loading = ref(true);
const form = ref<object>();

onMounted(async () => {
    loading.value = true
    await axios.post(props.form_url).then((response) => {
        form.value = response.data
        loading.value = false
    })
})

function store() {
    loading.value = true
    console.log(form.value);
    loading.value = false
}

</script>

<template>
    <preloader-component v-if="loading"></preloader-component>
    <form-component v-if="!loading" v-model="form"></form-component>

    <div class="row">
        <div class="col-12 col-md-6">
            <button class="btn btn-primary" @click="store()">Сохранить</button>
        </div>
        <div class="col-12 col-md-6">
            <a class="btn btn-secondary" :href="back_url">Назад</a>
        </div>
    </div>
</template>
