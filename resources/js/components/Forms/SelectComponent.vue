<script setup lang="ts">
import {computed, reactive} from "vue";

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    options: {
        type: [Array, Object],
        required: true,
    },
    defaultNothing: {
        type: Boolean,
        default: true,
    },
    multiple: {
        type: Boolean,
        default: false,
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
    error: {
        type: [String, Number, Array],
        default: null,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    displayName: {
        type: String,
        default: 'name',
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

function getName(option: any) {
    return option[props.displayName];
}

function change() {
    emits('update:modelValue', inputParams.value)
}
</script>

<template>
    <div
        class="form-input"
        :class="{'disabled': disabled}"
    >
        <select
            :id="inputParams.elementId"
            v-model="inputParams.value"
            :name="name"
            :disabled="disabled"
            :class="{'is_invalid': inputParams.hasError}"
            class="form-select cursor-pointer"
            @change="change"
        >
            <option v-if="defaultNothing" value=""></option>
            <option v-for="(option, index) in options" :key="index" :value="option.id" v-text="getName(option)"></option>
        </select>
        <label v-if="label" class="form-check-label cursor-pointer" :for="inputParams.elementId" v-text="label"></label>
        <span v-if="inputParams.hasError" class="invalid-feedback mt-0" v-text="inputParams.errorMessage"></span>
    </div>
</template>
