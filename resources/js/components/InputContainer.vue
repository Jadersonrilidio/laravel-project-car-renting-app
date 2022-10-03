<template>
    <div class="" :class="divClasses">
        <label :for="id" class="form-label">{{ title }}</label>
        <slot></slot>
        <div :id="idHelp" class="form-text"> {{ textHelp }} </div>
    </div>
</template>

<script>
    export default {
        props: [
            'divClasses',
            'id',
            'title',
            'idHelp',
            'textHelp'
        ],
    }
</script>