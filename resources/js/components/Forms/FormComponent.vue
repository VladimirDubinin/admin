<script setup lang="ts">
import {reactive} from "vue";
import InputTextComponent from "./InputTextComponent.vue";
import InputTextareaComponent from "./InputTextareaComponent.vue";
import SelectComponent from "./SelectComponent.vue";
import RadioComponent from "./RadioComponent.vue";
import CheckboxComponent from "./CheckboxComponent.vue";

const props = defineProps<{
    modelValue: object,
    errors?: object | []
}>()

const emits = defineEmits(['update:modelValue'])
const fields = reactive(props.modelValue)

function updated() {
    emits('update:modelValue', fields)
}
</script>

<template>
    <div>
        <div v-for="(item, index) in fields" :key="index" class="mb-3">
            <template v-if="item && item.type">
                <div v-if="item.type === 'text' || item.type === 'number' || item.type === 'email' || item.type === 'password'">
                    <input-text-component
                        v-model="item.value"
                        :id="item.id"
                        :readonly="item.readonly"
                        :name="item.name"
                        :disabled="item.disabled"
                        :label="item.label"
                        :placeholder="item.placeholder"
                        :type="item.type"
                        :error="errors ? errors[item.name] ?? '' : ''"
                        @change="updated"
                        class="mb-2"
                    />
                </div>

                <div v-else-if="item.type === 'textarea'">
                    <input-textarea-component
                        v-model="item.value"
                        :id="item.id"
                        :readonly="item.readonly"
                        :name="item.name"
                        :disabled="item.disabled"
                        :label="item.label"
                        :placeholder="item.placeholder"
                        :error="errors ? errors[item.name] ?? '' : ''"
                        @change="updated"
                        class="mb-2"
                    />
                </div>

                <div v-else-if="item.type === 'select'">
                    <select-component
                        v-model="item.value"
                        :id="item.id"
                        :default-nothing="item.defaultNothing"
                        :display-name="item.displayName"
                        :options="item.options"
                        :multiple="item.multiple"
                        :name="item.name"
                        :disabled="item.disabled"
                        :label="item.label"
                        :error="errors ? errors[item.name] ?? '' : ''"
                        @change="updated"
                        class="mb-2"
                    />
                </div>

                <div v-else-if="item.type === 'radio'">
                    <radio-component
                        v-model="item.value"
                        :id="item.id"
                        :options="item.options"
                        :name="item.name"
                        :disabled="item.disabled"
                        :label="item.label"
                        :error="errors ? errors[item.name] ?? '' : ''"
                        @change="updated"
                        class="mb-2"
                    />
                </div>

                <div v-else-if="item.type === 'checkbox'">
                    <checkbox-component
                        v-model="item.value"
                        :id="item.id"
                        :readonly="item.readonly"
                        :name="item.name"
                        :disabled="item.disabled"
                        :label="item.label"
                        :placeholder="item.placeholder"
                        :error="errors ? errors[item.name] ?? '' : ''"
                        @change="updated"
                        class="mb-2"
                    />
                </div>
            </template>
        </div>
    </div>
</template>
