<script setup lang="ts">
import {computed, reactive, ref} from "vue";

const props = defineProps({
    modelValue: {
        type: [File],
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
    name: {
        type: String,
        default: '',
    },
    id: {
        type: String,
        default: '',
    },
    accept: {
        type: String,
        default: '',
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    error: {
        type: [String, Number, Array],
        default: null,
    },
})

const emits = defineEmits(['update:modelValue'])

const inputParams = reactive({
    value: props.modelValue,
    elementId: props.id ? props.id : props.name,
    hasError: computed(() => !!props.error),
    errorMessage: computed(() => {
        if (Array.isArray(props.error)) {
            return props.error.join(', ');
        }
        return props.error;
    })
})

function change(event) {
    const files = event.target.files;
    if (files[0]) {
        inputParams.value = files[0];
        emits('update:modelValue', inputParams.value)
    }
}
</script>

<template>
    <div
        class="form-input"
    >
        <label v-if="label" class="form-control cursor-pointer" :for="inputParams.elementId" v-text="label"></label>
        <input
            :id="inputParams.elementId"
            :name="name"
            :class="{'is_invalid': inputParams.hasError}"
            class="form-control cursor-pointer"
            :accept="accept"
            :multiple ="multiple"
            type="file"
            @change="change"
        >
        <span v-if="inputParams.hasError" class="invalid-feedback mt-0" v-text="inputParams.errorMessage"></span>
    </div>
</template>
