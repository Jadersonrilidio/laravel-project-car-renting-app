<template>
    <div class="" :class="classes">
        <label :for="id" class="form-label">{{ title }}</label>
        <slot></slot>
        <div :id="idHelp" class="form-text"> {{ textHelp }} </div>
    </div>
</template>

<script>
    export default {
        props: [
            'classes',
            'id',
            'title',
            'idHelp',
            'textHelp',
        ],
    }
</script>