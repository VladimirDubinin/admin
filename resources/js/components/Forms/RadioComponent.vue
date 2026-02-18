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
        class="radio-switcher"
        :class="{'disabled': disabled}"
    >
        <div
            class="radio-bg d-flex align-items-center justify-content-between"
            :class=" {'is-invalid mb-1': inputParams.hasError,}"
        >
            <div class="radio-label">
                {{ label }}
            </div>
            <div class="radio-switcher-buttons">
                <template v-for="(option, index) in options" :key="index">
                    <input
                        :id="'radio_' + inputParams.elementId + index"
                        v-model="inputParams.value"
                        :value="option.value"
                        type="radio"
                        class="btn-check"
                        :name="name"
                        autocomplete="off"
                        :checked="inputParams.value === option.value"
                        @change="change"
                    >
                    <label class="btn" :for="'radio_' + inputParams.elementId + index" v-text="option.name"/>
                </template>
            </div>
        </div>
        <span v-if="inputParams.hasError" class="invalid-feedback mt-0" v-text="inputParams.errorMessage"></span>
    </div>
</template>
