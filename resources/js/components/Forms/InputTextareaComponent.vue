<script setup lang="ts">
import {computed, reactive} from "vue";

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
    placeholder: {
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
    error: {
        type: [String, Number, Array],
        default: null,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    readonly: {
        type: Boolean,
        default: false,
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

function change() {
    emits('update:modelValue', inputParams.value)
}
</script>

<template>
    <div
        class="form-input"
        :class="{'disabled': disabled}"
    >
        <label v-if="label" class="form-check-label cursor-pointer" :for="inputParams.elementId" v-text="label"></label>
        <textarea
            :id="inputParams.elementId"
            v-model="inputParams.value"
            :name="name"
            :disabled="disabled"
            :readonly="readonly"
            :class="{'is_invalid': inputParams.hasError}"
            class="form-control cursor-pointer"
            @change="change"
        />
        <span v-if="inputParams.hasError" class="invalid-feedback mt-0" v-text="inputParams.errorMessage"></span>
    </div>
</template>
